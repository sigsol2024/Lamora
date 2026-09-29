from __future__ import annotations

import io
import os
import re
import zipfile
from pathlib import Path

from docx import Document
from PIL import Image
from pypdf import PdfReader, PdfWriter
from reportlab.lib import colors
from reportlab.lib.enums import TA_CENTER
from reportlab.lib.pagesizes import A4
from reportlab.lib.styles import ParagraphStyle, getSampleStyleSheet
from reportlab.lib.units import inch
from reportlab.platypus import (
    Image as ReportLabImage,
    KeepTogether,
    PageBreak,
    Paragraph,
    SimpleDocTemplate,
    Spacer,
    Table,
    TableStyle,
)

ROOT = Path(__file__).resolve().parent
OUTPUT = ROOT / "output" / "pdf" / "Lamora_2026_Consolidated_Content_Guide.pdf"
WORK = ROOT / "tmp" / "pdfs"

PDF_SOURCES = [
    ("The Lamora Lagos Brand Guidelines 2026.pdf", "Brand Guidelines"),
    ("TLL Guest Facing Brand Application Standards.pdf", "Guest-Facing Brand Application Standards"),
    ("TLL Spec Sheet.pdf", "Specification Sheet"),
]
DOCX_SOURCE = "TLL Fact Sheet 2026 Rev1.docx"


def ascii_text(value: str) -> str:
    value = value.replace("\x00", " ")
    replacements = {"’": "'", "‘": "'", "“": '"', "”": '"', "–": "-", "—": "-", "•": "-", "…": "..."}
    for original, replacement in replacements.items():
        value = value.replace(original, replacement)
    return value.encode("ascii", "ignore").decode("ascii")


def clean(value: str) -> str:
    return re.sub(r"\s+", " ", ascii_text(value)).strip()


def safe_paragraph(value: str, style: ParagraphStyle) -> Paragraph:
    return Paragraph(value.replace("&", "&amp;").replace("<", "&lt;").replace(">", "&gt;"), style)


def page_heading(text: str) -> str:
    lines = [clean(line) for line in text.splitlines() if clean(line)]
    ignore = ("THE LAMORA LAGOS", "BRAND GUIDELINES", "TLL", "PAGE")
    useful = [line for line in lines if not any(marker in line.upper() for marker in ignore)]
    return (useful[0] if useful else (lines[0] if lines else "Visual reference page"))[:115]


def explanation(heading: str, source_name: str, text: str) -> str:
    content = clean(text)
    if not content:
        return f"This is a visual reference page in the {source_name}. Its supplied artwork is retained in the appendix so its composition, colour, and visual detail remain available."
    preview = content[:900]
    if len(content) > len(preview):
        preview += " ..."
    return f"This page sets out <b>{heading}</b> within the {source_name}. The extracted source content is reproduced below for searchability; the original, fully designed page follows in the appendix. <br/><br/>{preview}"


def add_page_number(canvas, document):
    canvas.saveState()
    canvas.setFont("Helvetica", 8)
    canvas.setFillColor(colors.HexColor("#52627A"))
    canvas.drawString(42, 25, "The Lamora Lagos - Consolidated Content Guide")
    canvas.drawRightString(A4[0] - 42, 25, f"Companion page {document.page}")
    canvas.restoreState()


def extract_docx_media(docx_path: Path) -> list[tuple[str, bytes]]:
    media: list[tuple[str, bytes]] = []
    with zipfile.ZipFile(docx_path) as archive:
        for name in archive.namelist():
            if name.startswith("word/media/"):
                media.append((Path(name).name, archive.read(name)))
    return media


def build_companion() -> Path:
    OUTPUT.parent.mkdir(parents=True, exist_ok=True)
    WORK.mkdir(parents=True, exist_ok=True)
    companion = WORK / "companion.pdf"
    styles = getSampleStyleSheet()
    styles.add(ParagraphStyle(name="Cover", parent=styles["Title"], fontName="Helvetica-Bold", fontSize=27, leading=32, textColor=colors.HexColor("#072163"), alignment=TA_CENTER, spaceAfter=18))
    styles.add(ParagraphStyle(name="Subtitle", parent=styles["BodyText"], fontSize=12, leading=17, alignment=TA_CENTER, textColor=colors.HexColor("#334155")))
    styles.add(ParagraphStyle(name="Section", parent=styles["Heading1"], fontName="Helvetica-Bold", fontSize=19, leading=24, textColor=colors.HexColor("#072163"), spaceBefore=12, spaceAfter=10))
    styles.add(ParagraphStyle(name="PageTitle", parent=styles["Heading2"], fontName="Helvetica-Bold", fontSize=13, leading=16, textColor=colors.HexColor("#072163"), spaceBefore=9, spaceAfter=5))
    styles.add(ParagraphStyle(name="BodySmall", parent=styles["BodyText"], fontSize=8.6, leading=11.5, textColor=colors.HexColor("#1E293B")))
    styles.add(ParagraphStyle(name="Note", parent=styles["BodyText"], fontSize=9, leading=12, textColor=colors.HexColor("#52627A")))

    story = [Spacer(1, 1.5 * inch), safe_paragraph("The Lamora Lagos", styles["Cover"]), safe_paragraph("2026 Consolidated Content Guide", styles["Cover"]), Spacer(1, 0.2 * inch), safe_paragraph("A searchable companion to the supplied brand, guest-application, specification, and fact-sheet documents.", styles["Subtitle"]), Spacer(1, 0.45 * inch)]
    source_rows = [[safe_paragraph("Source", styles["BodySmall"]), safe_paragraph("Included content", styles["BodySmall"])]]
    for filename, label in PDF_SOURCES:
        source_rows.append([safe_paragraph(label, styles["BodySmall"]), safe_paragraph(f"Page-by-page explanation plus {len(PdfReader(ROOT / filename).pages)} original pages in the appendix.", styles["BodySmall"])])
    source_rows.append([safe_paragraph("Fact Sheet", styles["BodySmall"]), safe_paragraph("All available paragraphs, tables, and embedded images are transcribed or reproduced in this companion.", styles["BodySmall"])])
    table = Table(source_rows, colWidths=[2.25 * inch, 4.65 * inch])
    table.setStyle(TableStyle([("BACKGROUND", (0, 0), (-1, 0), colors.HexColor("#072163")), ("TEXTCOLOR", (0, 0), (-1, 0), colors.white), ("GRID", (0, 0), (-1, -1), 0.35, colors.HexColor("#CBD5E1")), ("VALIGN", (0, 0), (-1, -1), "TOP"), ("LEFTPADDING", (0, 0), (-1, -1), 8), ("RIGHTPADDING", (0, 0), (-1, -1), 8), ("TOPPADDING", (0, 0), (-1, -1), 7), ("BOTTOMPADDING", (0, 0), (-1, -1), 7), ("BACKGROUND", (0, 1), (-1, -1), colors.HexColor("#F8FAFC"))]))
    story += [table, Spacer(1, 0.35 * inch), safe_paragraph("How to use this guide", styles["Section"]), safe_paragraph("The front section makes each supplied page understandable in plain context and preserves its extractable text. The original PDF pages are then appended unchanged, ensuring that page design, logos, diagrams, and photography are not lost. The Word fact sheet is transcribed because it was not supplied as a PDF.", styles["BodyText"]), PageBreak()]

    for filename, label in PDF_SOURCES:
        reader = PdfReader(ROOT / filename)
        story += [safe_paragraph(label, styles["Section"]), safe_paragraph(f"{len(reader.pages)} supplied pages. Every page below is explained and its text is retained; the original designed pages appear later in the appendix.", styles["Note"])]
        for number, page in enumerate(reader.pages, 1):
            source_text = page.extract_text() or ""
            heading = page_heading(source_text)
            story += [safe_paragraph(f"Source page {number}: {heading}", styles["PageTitle"]), safe_paragraph(explanation(heading, label, source_text), styles["BodySmall"]), Spacer(1, 7)]
        story.append(PageBreak())

    document = Document(ROOT / DOCX_SOURCE)
    story += [safe_paragraph("Fact Sheet 2026", styles["Section"]), safe_paragraph("The following transcription includes the Word document's paragraphs and all 18 tables. Embedded images are reproduced after the structured content.", styles["Note"])]
    for index, paragraph in enumerate(document.paragraphs, 1):
        text = clean(paragraph.text)
        if text:
            story.append(safe_paragraph(f"<b>Paragraph {index}.</b> {text}", styles["BodySmall"]))
            story.append(Spacer(1, 4))
    for index, word_table in enumerate(document.tables, 1):
        story += [safe_paragraph(f"Fact sheet table {index}", styles["PageTitle"])]
        data = []
        for row in word_table.rows:
            cells = [safe_paragraph(clean(cell.text) or "-", styles["BodySmall"]) for cell in row.cells]
            data.append(cells)
        if data:
            widths = [6.9 * inch / len(data[0])] * len(data[0])
            rendered = Table(data, colWidths=widths, repeatRows=1)
            rendered.setStyle(TableStyle([("GRID", (0, 0), (-1, -1), 0.3, colors.HexColor("#94A3B8")), ("BACKGROUND", (0, 0), (-1, 0), colors.HexColor("#E2E8F0")), ("VALIGN", (0, 0), (-1, -1), "TOP"), ("LEFTPADDING", (0, 0), (-1, -1), 5), ("RIGHTPADDING", (0, 0), (-1, -1), 5), ("TOPPADDING", (0, 0), (-1, -1), 4), ("BOTTOMPADDING", (0, 0), (-1, -1), 4)]))
            story += [rendered, Spacer(1, 8)]
    media = extract_docx_media(ROOT / DOCX_SOURCE)
    if media:
        story += [PageBreak(), safe_paragraph("Fact Sheet Embedded Images", styles["Section"]), safe_paragraph("These are the visual assets embedded in the supplied Word fact sheet. They are retained here so the consolidated file carries both its textual and visual content.", styles["Note"])]
        for name, raw in media:
            try:
                image = Image.open(io.BytesIO(raw))
                width, height = image.size
                max_width, max_height = 5.9 * inch, 4.7 * inch
                scale = min(max_width / width, max_height / height)
                flowable = ReportLabImage(io.BytesIO(raw), width=width * scale, height=height * scale)
                story += [safe_paragraph(name, styles["PageTitle"]), flowable, Spacer(1, 10)]
            except Exception:
                story.append(safe_paragraph(f"Embedded asset {name} could not be rendered directly; it remains inside the supplied Word file.", styles["BodySmall"]))
    story += [PageBreak(), safe_paragraph("Original PDF Appendix", styles["Section"]), safe_paragraph("The next pages are the supplied PDFs merged unchanged. This appendix preserves the original photography, logos, graphic layouts, diagrams, and print-ready visual treatments.", styles["BodyText"])]
    SimpleDocTemplate(str(companion), pagesize=A4, rightMargin=42, leftMargin=42, topMargin=42, bottomMargin=42, title="Lamora 2026 Consolidated Content Guide", author="The Lamora Lagos").build(story, onFirstPage=add_page_number, onLaterPages=add_page_number)
    return companion


def merge_originals(companion: Path) -> None:
    writer = PdfWriter()
    writer.append(str(companion))
    for filename, _label in PDF_SOURCES:
        writer.append(str(ROOT / filename))
    with OUTPUT.open("wb") as stream:
        writer.write(stream)


if __name__ == "__main__":
    merge_originals(build_companion())
    print(OUTPUT)
