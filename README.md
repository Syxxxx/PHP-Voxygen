# PHP VoiceBox

## Qu'est-ce que PHP VoiceBox ?

PHP VoiceBox est un service en ligne permettant d'utiliser la synthèse vocale de Voxygen.fr sans avoir à passer par leur interface.

## Euh, mais quelles différences entre ce fork et la version originale ?

* Correction de bugs (le nom des fichiers est désormais basé sur un md5 du texte et de la voix choisis, et non plus un nombre aléatoire, la déclaration UTF-8 respecte désormais la syntaxe conseillée pour le HTML5)
* Nettoyage du code (passage avec du code redondant simplifiés, remplacement de string_between() par un bête preg_match(), fonction curl_post() remplacée par une fonction custom plus légère)
* Citation d'Apcros enlevée (3615 personnal branling, j'écoute ?)
* Remplacement du player de Google par Dewplayer et mise par défaut du player flash (si l'utilisateur possède flash)
* Intégration des libraires en local
* Ajout d'un filtre anti-censure
* Vérifications lorsque l'utilisateur ne rentre pas de texte ou que Voxygen renvoie des trucs chelou
* Création d'une classe Voxygen

## Testé sous

* iOS 5.0
* Firefox 16
* Chrome 23

## On me dit que Voxygen a changé ses API, alors que PHP VoiceBox fonctionne sur un autre serveur. Pourquoi ?

J'ai eu ce problème une fois, quand je voulais faire une démo dans un lieu où le pare-feu était assez restrictif. Vérifiez vos réglages réseaux et votre serveur web.

## Filtre GROMMO (anti-censure)

Ce filtre permet d'autoriser quelques mots "interdits" par VoxyGen.fr d'être prononcés. La base de données s'élève actuellement à un nombre limité de "traductions" mais si il y a des gens qui seraient intéressés pour m'aider, je suis prenneur, le système est fait, maintenant, il ne reste plus qu'à ajouter vos équivalents gros-mot -> charabia :)

## Dossier cache

PHP VoiceBox ne dispose pas actuellement de système de vidage du cache.

> rm -rf cache/*

Démerdez-vous avec ça :>

## Utilisation de PHP VoiceBox avec des applications tierces

PHP VoiceBox a sa classe pour être utilisé dans vos propres applications. Libre à vous d'optimiser cette classe, j'accepte les pull-request (pour peu que vous me foutez pas de la merde ^.^).

Elle se trouve dans /engine.php, et elle s'utilise de la manière suivante :

```php
<?php
	$voxygenHandler = new Voxygen(Activation de GROMMO : (bool),Dossier de stockage du cache : (string));
	$voxygenHandler->voiceSynthesis(Voix : (string),Texte : (string)); // Retourne url du fichier stocké (string)
?>
```

## Licences

PHP VoiceBox utilise la synthèse vocale de Voxygen.fr, l'utilisation des fichiers obtenus est donc réglementée par le service. PHP VoiceBox utilise aussi le Bootstrap Twitter sous licence Apache v2.0 ainsi que Dewplayer sous licence Creative Commons BY-ND.

## Releases
* [Version 0.5](https://github.com/tibounise/PHP-VoiceBox/tree/ed52d9576e7e539bc7c6b2ec5818ad2f6b08518c)
* [Version 0.4](https://github.com/tibounise/PHP-VoiceBox/tree/0f187635ea6375accbf76b8fed2718ed984e63f8)
* [Version 0.3](https://github.com/tibounise/PHP-VoiceBox/tree/bcfa90a2f693e928d216f8dee9e401137d78411d)
* [Version 0.2](https://github.com/tibounise/PHP-VoiceBox/tree/02d1ba169e6dd0d04f59a60658999e5edaa4e67e)
* [Version 0.1](https://github.com/tibounise/PHP-VoiceBox/tree/1136cdf19f15b0c7db43ebd47baebc55cc9b0848)