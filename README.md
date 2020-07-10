# Simulateur de rentabilité gestion de copropriétés - Cotoit
Application web destinée à un usage interne pour l'ensemble des agences. Il permet le chargement d'un portefeuille de gestion de copropriétés sous format CSV, afin de rendre plusieurs indicateurs sur la rentabilité de ce portefeuille sous forme d'infographie téléchargeable en format PDF.

## Installer le projet
1. Cloner le repository
2. Créer un fichier .env.local à partir du fichier .env et renseigner vos données :  
*db_user* = votre nom d'utilisateur  
*db_password* = votre mot de passe  
*db_name* = le nom de la base de données  
`DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name`

3. Installer Composer :
`$ composer install`

4. Installer yarn
`$ yarn install`

5. Créer la base de données :
`$ php bin/console doctrine:database:create`

6. Mettre à jour la base de données :
`$ php bin/console doctrine:schema:update --force`

7. Charger les fixtures :
`$ php bin/console doctrine:fixture:load`

8. Compiler le SCSS avec la commande :
`$ yarn encore dev`

9. Lancer le serveur :
`$ symfony server:start`

## Outils de développement
* Symfony 4.4
* PHP 7.2
* SCSS

## Contributeurs
[Amandine HELENE](https://github.com/Heldeenn)  
[Julien JOURDEN](https://github.com/eozen-git)  
[Mao MATER](https://github.com/maoherve)  
[Monya RAZOKI](https://github.com/MonyaMya)

### Windows Users

If you develop on Windows, you should edit you git configuration to change your end of line rules with this command :

`git config --global core.autocrlf true`
