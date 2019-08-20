ALTER TABLE `messages` 
ADD `Les_Liens` VARCHAR( 20 ) NOT NULL  AFTER `categorie`,
ADD `Les_Pilotes` VARCHAR( 20 ) NOT NULL AFTER `categorie`,
ADD `Les_Outils` VARCHAR( 20 ) NOT NULL AFTER `categorie`, 
ADD `Le_Support` VARCHAR( 20 ) NOT NULL AFTER `categorie`, 
ADD `Les_Services` VARCHAR( 20 ) NOT NULL AFTER `categorie`, 
ADD `Les_Produits` VARCHAR( 20 ) NOT NULL AFTER `categorie`;       