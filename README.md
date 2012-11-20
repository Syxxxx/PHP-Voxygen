# PHP VoiceBox

## Qu'est-ce que PHP VoiceBox ?

PHP VoiceBox est un service en ligne permettant d'utiliser la synthèse vocale de Voxygen.fr sans avoir à passer par leur interface.

## Euh, mais quelles différences entre ce fork et la version originale ?

* Correction de bugs (le nom des fichiers est désormais basé sur un md5 du texte et de la voix choisis, et non plus un nombre aléatoire, la déclaration UTF-8 respecte désormais la syntaxe conseillée pour le HTML5)
* Nettoyage du code (passage avec du code redondant simplifiés, remplacement de string_between() par un bête preg_match())
* Citation d'Apcros enlevée (3615 personnal branling, j'écoute ?)
* Remplacement du player de Google par Dewplayer et mise par défaut du player flash (si l'utilisateur possède flash)
* Intégration des libraires en local
* Ajout d'un filtre anti-censure

## Testé sous

* iOS 5.0
* Firefox 16
* Chrome 23

## Todo-list

* Remplacer le curl_post() par quelque chose de moins crade
* Améliorer l'anti-censure
* Système de vidage du cache

## Filtre GROMMO (anti-censure)

Ce filtre permet d'autoriser quelques mots "interdits" par VoxyGen.fr d'être prononcés. La base de données s'élève actuellement à deux "traductions" (youpi !) mais si il y a des gens qui seraient intéressés pour m'aider, je suis prenneur, le système est fait, maintenant, il ne reste plus qu'à ajouter vos équivalents gros-mot -> charabia :)

## Dossier cache

PHP VoiceBox ne dispose pas actuellement de système de vidage du cache.

> rm -rf cache/*

Démerdez-vous avec ça :>

## Licences

PHP VoiceBox utilise la synthèse vocale de Voxygen.fr, l'utilisation des fichiers obtenus est donc réglementée par le service. PHP VoiceBox utilise aussi le Bootstrap Twitter sous licence Apache v2.0 ainsi que Dewplayer sous licence Creative Commons BY-ND.

## Releases

* [Version 0.1](https://github.com/tibounise/PHP_VoiceBox/tree/f173c7b3a2880c0d39fc89aa5701ba4baa4ba43d)