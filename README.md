 SEMMARIS - Migration PHP5 vers PHP8.3

 
 Description:
Ce projet consiste à moderniser un ancien site web PHP5 de la SEMMARIS (gestion du Marché de Rungis) en PHP 8.3, en suivant une architecture MVC. L'objectif était de rendre le site maintenable, sécurisé et compatible avec les versions modernes de PHP.

Le projet inclut :  
- Migration de PHP5 vers PHP8.3.  
- Refactorisation en MVC (Models, Views, Controllers).  
- Correction de bugs critiques (ex : boutons inactifs).  
- Optimisation des requêtes SQL et gestion de la limite de 2100 paramètres dans `WHERE IN`.  
- Sécurisation des affichages HTML et protection contre les failles XSS.  
- Utilisation d’ODBC pour l’accès à une base SQL Server.



Fonctionnalités principales:
- Consultation et gestion des cartes d’accès.  
- Visualisation des passages et historiques des cartes.  
- Formulaires sécurisés pour l’édition et l’ajout de données.  
- Affichage clair et structuré des informations via la séparation MVC.
- Création d'un lofin pou rla connection des utilisateurs
- (Protocole SAML pour le SSO à finir)
