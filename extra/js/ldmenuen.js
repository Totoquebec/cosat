/**
 * mm_menu 20MAR2002 Version 6.0
 * Andy Finnell, March 2002
 * Copyright (c) 2000-2002 Macromedia, Inc.
 *
 * based on menu.js
 * by gary smith, July 1997
 * Copyright (c) 1997-1999 Netscape Communications Corp.
 *
 * Netscape grants you a royalty free license to use or modify this
 * software provided that this copyright notice appears on all copies.
 * This software is provided "AS IS," without a warranty of any kind.
 */

function mmLoadMenus() {
  if (window.mm_menu_Liens) return;

  window.mm_menu_Liens = new Menu("root",126,22,11,"left","middle",3,0,1000,-5,7,true,false,true,0,false,false);
  mm_menu_Liens.addMenuItem("Rechercher","location='Lienlst.php'");
  mm_menu_Liens.addMenuItem("Ajouter","location='Liensjout.php'");
   mm_menu_Liens.hideOnMouseOut=true;
   
  window.mm_menu_Catalogue = new Menu("root",126,22,11,"left","middle",3,0,1000,-5,7,true,false,true,0,false,false);
  mm_menu_Catalogue.addMenuItem("Find","location='catalogue_recherche.php'");
  mm_menu_Catalogue.addMenuItem("Add","location='catalogue_ajout.php'");
  mm_menu_Catalogue.addMenuSeparator();
  mm_menu_Catalogue.addMenuItem("Report","location='catalogue_rapport.php'");
   mm_menu_Catalogue.hideOnMouseOut=true;
   
  window.mm_menu_Produits = new Menu("root",126,22,11,"left","middle",3,0,1000,-5,7,true,false,true,0,false,false);
  mm_menu_Produits.addMenuItem("Find","location='produits_recherche.php'");
  mm_menu_Produits.addMenuItem("Add","location='produits_ajout.php'");
  mm_menu_Produits.addMenuItem("Special","location='speciaux_consulte.php'");
  mm_menu_Produits.addMenuSeparator();
  mm_menu_Produits.addMenuItem("Catalogue","location='produits_catalogue.php'");
  mm_menu_Produits.addMenuItem("Report","location='produits_recherche.php?do=list'");
   mm_menu_Produits.hideOnMouseOut=true;
   
  window.mm_menu_Prospects = new Menu("root",126,22,11,"left","middle",3,0,1000,-5,7,true,false,true,0,false,false);
  mm_menu_Prospects.addMenuItem("Consult","location='prospect.php'");
//  mm_menu_Prospects.addMenuItem("Report","location='construction.html'");
   mm_menu_Prospects.hideOnMouseOut=true;
   

    window.mm_menu_Options = new Menu("root",116,22,11,"left","middle",3,0,1000,-5,7,true,false,true,0,false,false);
  mm_menu_Options.addMenuItem("Support","location='support.php'");
  mm_menu_Options.addMenuItem("Text","location='texte.php'");
  mm_menu_Options.addMenuItem("Parameter","location='param.php'");
    mm_menu_Options.addMenuItem("SiteMap","location='plan_modif.php'");
    mm_menu_Options.addMenuItem("Carousel","location='carrousel_modif.php'");
  mm_menu_Options.addMenuSeparator();
  mm_menu_Options.addMenuItem("Quit","top.location='bye.php'","#FFFF66");
   mm_menu_Options.hideOnMouseOut=true;
/*   mm_menu_Options.menuBorder=1;
   mm_menu_Options.menuLiteBgColor='#ffffff';
   mm_menu_Options.menuBorderBgColor='#555555';
   mm_menu_Options.bgColor='#555555';*/


  mm_menu_Options.writeMenus();
} // mmLoadMenus()
