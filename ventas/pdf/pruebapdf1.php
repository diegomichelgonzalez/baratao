<?php
//AddPage(orientacion[PORTRAIT, LANDSCAPE], tamaño[A3, A4, A5, LETTER, LEGAL]),
//SetFont(tipo[COURIER, HELVETICA, ARIAL, TIMES, SYMBOL, ZAPDINGBATS], estilo[normal, B, I, U], tamaño),
//Cell(ancho, alto, texto, border, ?, alineacion, rellenar, link),
//Write(alto, texto, link)
//OutPut(destino[I, D, F, S], nombre_archivo, rellenar link),
require("fpdf/fpdf.php");
$fpdf = new FPDF();
$fpdf->AddPage();
$fpdf->SetFont("Arial", "", 12);
$fpdf->Cell(30,5, "Hola JosyMat");
$fpdf->OutPut();