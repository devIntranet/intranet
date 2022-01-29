<?php
header("Content-Type: text/css");
define("ROOT", "http://hp-wsus/new/");
?>

div::-webkit-scrollbar {
    width: 15px;
}

div::-webkit-scrollbar-track {
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
    border-radius: 20px;
}

div::-webkit-scrollbar-thumb {
    border-radius: 10px;
    -webkit-box-shadow: inset 0 0 20px rgba(0,0,0,0.5);
}​

@charset "iso-8859-2";
/* CSS Document */

@font-face {
	font-family: tahoma;
	src: url('<?=ROOT?>/img/tahoma.ttf') format("truetype");
}
html, body {
	background-color: #fff;
	color: #000;
	margin: 0;
	padding: 0;
}

#main {
	margin:0 auto;
	width: 1050px;
}

#TOP {
	width: 1024px;
	height: 177px;
}
#PASEK_TOP {
	-webkit-transition: width 2s; /* Safari and Chrome */
    border-radius:15px;
    width: 780px;
	height: 60px;
    overflow: visible;
    padding: 10px 23px 0px;
    -webkit-box-shadow: 3px 3px 4px rgba(177, 171, 171, 0.56);
    background-color:rgba(204, 204, 204, 0.22);

}

#MENU {
	width: 202px;
	float: right;

}
#VOID_MENU {
	height: 180px;
}
#VOID_MENU2 {
	height: 164px;
}

#LINK {
	width: 202px;
	height: 48px;

}

#HR {
	width: 20px;
	float: right;
	overflow: hidden;
}

#TRESC {
	width: 828px;
	height: 495px;
	overflow: auto;
}

#BOTTOM {
	width: 1024px;
	clear: both;
	width: 100%;
}

img.dokument {
	height: 72px;
    width: 72px;
    float: left;
    clear:left;
}
.i_login {

    width: 160px;
}
.s_password {

    border: none;
	width: 45px;
	height: 45px;
	background: url('<?=ROOT?>/img/klodka.jpg');
}
.s_password:hover{

	position:relative;
    cursor: pointer;
    border: none;
	width: 45px;
	height: 45px;
	background: url('<?=ROOT?>/img/klodka1.jpg');
}
.s_zloz {

    border: none;
	width: 100px;
	height: 24px;
	background: url('<?=ROOT?>/img/zloz.png');
}
.s_zloz:hover{

	position:relative;
    cursor: pointer;
    border: none;
	width: 100px;
	height: 24px;
	background: url('<?=ROOT?>/img/zloz1.png');
}
.s_nowe {

    border: none;
	width: 100px;
	height: 24px;
	background: url('<?=ROOT?>/img/nowe.png');
}
.s_nowe:hover{

	position:relative;
    cursor: pointer;
    border: none;
	width: 100px;
	height: 24px;
	background: url('<?=ROOT?>/img/nowe1.png');
}
.s_otwarte {

    border: none;
	width: 100px;
	height: 24px;
	background: url('<?=ROOT?>/img/otwarte.png');
}
.s_otwarte:hover{

	position:relative;
    cursor: pointer;
    border: none;
	width: 100px;
	height: 24px;
	background: url('<?=ROOT?>/img/otwarte1.png');
}
.s_zakonczone {

    border: none;
	width: 140px;
	height: 24px;
	background: url('<?=ROOT?>/img/zakonczone.png');
}
.s_zakonczone:hover{

	position:relative;
    cursor: pointer;
    border: none;
	width: 140px;
	height: 24px;
	background: url('<?=ROOT?>/img/zakonczone1.png');
}
.s_odwolane {

    border: none;
	width: 140px;
	height: 24px;
	background: url('<?=ROOT?>/img/odwolane.png');
}
.s_odwolane:hover{

	position:relative;
    cursor: pointer;
    border: none;
	width: 140px;
	height: 24px;
	background: url('<?=ROOT?>/img/odwolane1.png');
}
.s_wszystkie {

    border: none;
	width: 140px;
	height: 24px;
	background: url('<?=ROOT?>/img/wszystkie.png');
}
.s_wszystkie:hover{

	position:relative;
    cursor: pointer;
    border: none;
	width: 140px;
	height: 24px;
	background: url('<?=ROOT?>/img/wszystkie1.png');
}
.s_zaspap {

    border: none;
	width: 140px;
	height: 24px;
	background: url('<?=ROOT?>/img/zaspap.png');
}
.s_zaspap:hover{

	position:relative;
    cursor: pointer;
    border: none;
	width: 140px;
	height: 24px;
	background: url('<?=ROOT?>/img/zaspap1.png');
}
.s_moduly {

    border: none;
	width: 140px;
	height: 24px;
	background: url('<?=ROOT?>/img/moduly.png');
}
.s_moduly:hover{

	position:relative;
    cursor: pointer;
    border: none;
	width: 140px;
	height: 24px;
	background: url('<?=ROOT?>/img/moduly1.png');
}
.s_ewidencja {

    border: none;
	width: 140px;
	height: 24px;
	background: url('<?=ROOT?>/img/ewidencja.png');
}
.s_ewidencja:hover{

	position:relative;
    cursor: pointer;
    border: none;
	width: 140px;
	height: 24px;
	background: url('<?=ROOT?>/img/ewidencja1.png');
}
.s_mojewn {

    border: none;
	width: 140px;
	height: 24px;
	background: url('<?=ROOT?>/img/mojewn.png');
}
.s_mojewn:hover{

	position:relative;
    cursor: pointer;
    border: none;
	width: 140px;
	height: 24px;
	background: url('<?=ROOT?>/img/mojewn1.png');
}
.s_zlozwn {

    border: none;
	width: 140px;
	height: 24px;
	background: url('<?=ROOT?>/img/zlozwn.png');
}
.s_zlozwn:hover{

	position:relative;
    cursor: pointer;
    border: none;
	width: 140px;
	height: 24px;
	background: url('<?=ROOT?>/img/zlozwn1.png');
}
.menuBaza1 {
	width: 90%; 
    margin-left: auto;
    margin-right: auto;
}
.menuBaza2 {
	width: 97%; 
    margin-left: auto;
    margin-right: auto;
}
.m_uzytkownicy {

	float: left;
    position: relative;
	width: 140px;
	height: 24px;
	background-image: url('<?=ROOT?>/img/button/uzytkownicy.png');
}
.m_uzytkownicy:hover {


	float: left;
    position: relative;
	width: 140px;
	height: 24px;
	background-image: url('<?=ROOT?>/img/button/uzytkownicy_hover.png');
}
.m_dzialy {
	float: left;
	position:relative;
	width: 140px;
	height: 24px;
	background-image: url('<?=ROOT?>/img/button/dzialy.png');
}
.m_dzialy:hover {
	float: left;
	position:relative;
	width: 140px;
	height: 24px;
	background-image: url('<?=ROOT?>/img/button/dzialy_hover.png');
}

.m_komputery {
	float: left;
	position:relative;
	width: 140px;
	height: 24px;
	background-image: url('<?=ROOT?>/img/button/komputery.png');
}
.m_komputery:hover {
	foat: left;
	position:relative;
	width: 140px;
	height: 24px;
	background-image: url('<?=ROOT?>/img/button/komputery_hover.png');
}
.m_monitory {
	float: left;
	position:relative;
	width: 140px;
	height: 24px;
	background-image: url('<?=ROOT?>/img/button/monitory.png');
}
.m_monitory:hover {
	float: left;
	position:relative;
	width: 140px;
	height: 24px;
	background-image: url('<?=ROOT?>/img/button/monitory_hover.png');
}
.m_upsy{
	display: block;
    float: left;
	position:relative;
	width: 140px;
	height: 24px;
	background-image: url('<?=ROOT?>/img/button/upsy.png');
}
.m_upsy:hover {
	float: left;
	position:relative;
	width: 140px;
	height: 24px;
	background-image: url('<?=ROOT?>/img/button/upsy_hover.png');
}
.m_drukskan{
	float: left;
	position:relative;
	width: 140px;
	height: 24px;
	background-image: url('<?=ROOT?>/img/button/drukskan.png');
}
.m_drukskan:hover {
	float: left
	position:relative;
	width: 140px;
	height: 24px;
	background-image: url('<?=ROOT?>/img/button/drukskan_hover.png');
}
.m_programy{
	float: left;
	position:relative;
	width: 140px;
	height: 24px;
	background-image: url('<?=ROOT?>/img/button/programy.png');
}
.m_programy:hover {
	float: left
	position:relative;
	width: 140px;
	height: 24px;
	background-image: url('<?=ROOT?>/img/button/programy_hover.png');
}
.m_szukacz{
	float: left;
	position:relative;
	width: 140px;
	height: 24px;
	background-image: url('<?=ROOT?>/img/button/szukacz.png');
}
.m_szukacz:hover {
	float: left
	position:relative;
	width: 140px;
	height: 24px;
	background-image: url('<?=ROOT?>/img/button/szukacz_hover.png');
}
.m_historia{
	float: left;
	position:relative;
	width: 140px;
	height: 24px;
	background-image: url('<?=ROOT?>/img/button/historia.png');
}
.m_historia:hover {
	float: left
	position:relative;
	width: 140px;
	height: 24px;
	background-image: url('<?=ROOT?>/img/button/historia_hover.png');
}
.m_wroc{
	float: left;
	position:relative;
	width: 140px;
	height: 24px;
	background-image: url('<?=ROOT?>/img/button/wroc.png');
}
.m_wroc:hover {
	float: left
	position:relative;
	width: 140px;
	height: 24px;
	background-image: url('<?=ROOT?>/img/button/wroc_hover.png');
}

.l_glowna {
	display: block;
	position:relative;
	width: 202px;
	height: 48px;
	background-image: url('<?=ROOT?>/img/glowna.jpg');
}
.l_glowna:hover {
	display: block;
	position:relative;
	width: 202px;
	height: 48px;
	background-image: url('<?=ROOT?>/img/glowna1.jpg');
}

.l_wnioski {
	display: block;
	width: 202px;
	height: 48px;
	background: url('<?=ROOT?>/img/wnioski.jpg');
	text-indent: -99999px;
}
.l_wnioski:hover {
	background: url('<?=ROOT?>/img/wnioski1.jpg');
}
.l_upowaznienia {
	display: block;
	width: 202px;
	height: 48px;
	background: url('<?=ROOT?>/img/upowaznienia.jpg') bottom;
	text-indent: -99999px;
}
.l_upowaznienia:hover {
	background: url('<?=ROOT?>/img/upowaznienia1.jpg') bottom;
}
.l_telefony {
	display: block;
	width: 202px;
	height: 48px;
	background: url('<?=ROOT?>/img/telefony.jpg') bottom;
	text-indent: -99999px;
}
.l_telefony:hover {
	background: url('<?=ROOT?>/img/telefony1.jpg') bottom;
}
.l_dokumenty {
	display: block;
	width: 202px;
	height: 48px;
	background: url('<?=ROOT?>/img/dokumenty.jpg') bottom;
	text-indent: -99999px;
}
.l_dokumenty:hover {
	background: url('<?=ROOT?>/img/dokumenty1.jpg') bottom;
}
.l_instrukcje {
	display: block;
	width: 202px;
	height: 48px;
	background: url('<?=ROOT?>/img/instrukcje.jpg') bottom;
	text-indent: -99999px;
}
.l_instrukcje:hover {
	background: url('<?=ROOT?>/img/instrukcje1.jpg') bottom;
}
.l_baza {
	display: block;
	width: 202px;
	height: 48px;
	background: url('<?=ROOT?>/img/baza.jpg') bottom;
	text-indent: -99999px;
}
.l_baza:hover {
	background: url('<?=ROOT?>/img/baza1.jpg') bottom;
}
.l_logout {
	display: block;
	width: 45px;
	height: 45px;
	background: url('<?=ROOT?>/img/klodka1.jpg') bottom;
}
.l_logout:hover{

	position:relative;
    cursor: pointer;
    border: none;
	width: 45px;
	height: 45px;
	background: url('<?=ROOT?>/img/klodka.jpg');
}
.zaspapgr {
   text-align: left;
   font-size: 13px;
   font-family:  tahoma;
   border: 1px solid black;
   border-style: dotted;
   }
    .verticaltext{
	font: bold 13px Courier, monospace;
	position: absolute;
	right: 3px;
	top: 20px;
	width: 15px;
	writing-mode: tb-rl;
}
table.dot {
	border-width: 1px;
	border-spacing: 0px;
    border-collapse: collapse;
	border-style: dotted;
	border-color: #000000;
	}
table.imienazw {
   font-size: 12px;
   font-family:  tahoma;
   font-weight: 700;
   border: none;
   }
td.dot {
   text-align: left;
   font-size: 11px;
   font-family: tahoma;
   border: 1px solid black;
   border-style: dotted;
   }
td.dot_def {
   text-align: left;
   font-size: 10px;
   font-family: tahoma;
   border: 1px solid black;
   border-style: dotted;
   background-color: #fdb675;
   }
tr.topdot {
   text-align: left;
   font-size: 17px;
   font-family: tahoma;
   border: 1px solid black;
   border-style: dotted;
   }
td.topdot {
   text-align: left;
   font-size: 12px;
   font-family: tahoma;
   #border: 1px solid black;
   #border-style: dotted;
 }
TR.wn_top {
	font-family: tahoma;
    font-weight: bold;
	font-size: 14px;
}
.dymek {
		position:absolute;display:none;left:10px;top:20px;
		border:1px double orange;background-color:white;
		padding:6px;font:normal 12px serif;
}
.clear {
	clear: left;
}
a.nag, a:visited.nag, a:active.nag {
	text-decoration: none;
    font-size: 14px;
    font-family: tahoma;
    font-weight: bold;
    color: rgb(64,163,219);
}
tr.hov:hover {
	background-color: rgba(64,163,219,0.3);
}