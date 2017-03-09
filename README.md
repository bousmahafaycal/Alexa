# Alexa

## Introduction
### Le concept
C'est un site d'informations collaboratif ou tout le monde peut poster ses articles. 
Il y a plusieurs type de membres. Le membre de base peut ajouter des articles, gagner des points, choisir un autre thème visuel (gérer ses
préferences de manières générales). Il peut également supprimer ses propres articles. Les memebrs peuvent également mettre un pouce bleu
et/ou un pouce rouge à un commentaire.


Certains membres sont modérateurs, ce qui permet en plus de valider des articles et des commentaires.


D'autres membres sont administrateurs, ils ont alors en plus le droit de supprimer/modifier un article/commentaire. Ils peuvent également le rendre
"payant". En effet, si certains articles sont visibles par tous les utilisateurs du site, d'autres sont réservé aux membres inscrits
possédant des points. Lors de l'inscription on reçoit 200 points. On peut en gagner 30 en regardant une petite vidéo. A chaque fois
qu'on souhaite regarder un nouvel article premium, on "paye" 1 point. 

Enfin, un nombre restreint de membres sont super-administrateurs.
En plus des droits de l'administrateurs, ces derniers peuvent bannir des personnes ou modifier leurs droits (les rétrograder ou les promouvoir).



### Contexte de création
Site web d'informations réalisé pour le projet d'IO2 (Informatique et Outils du Numérique, matière en licence 1 d'informatique à l'université Paris Diderot (Paris 7))
lors duquel j'ai eu la note de 20/20. Ce projet était à faire par groupe de 2 personnes.


Je me suis occupé de la conception du site et de la base de données, de la réalisation du javascript et de la grande majorité du PHP/HTML. 
Pendant, ce temps la, mon camarade s'est occupé du CSS, des logos et des pages en PHP montrant tous les articles du sites et celles montrant les articles selon une catégorie donnée.


Pour ce projet, les templates et framework n'étaient pas autorisés. Ce site a donc été conçu à partir de rien, c'est à dire que tout le code
a été spécialement créer pour ce site.


## Live test
Pour tester le site, il suffit d'aller sur : <http://alexa.bousmaha.com>.


## Test
Pour tester ce site, il suffit d'avoir un serveur fonctionnant avec PHP et MySQL. Après avoir cloné le dépot, il faut importer alexa.sql dans la base de données
et mettre les informations de connexion à la base de données dans connexionbdd.php. Enfin, en lançant index.php dans le navigateur,
le site devrait fonctionner.



## A améliorer
Voici une liste non exhaustive de fonctionnalités à ajouter/améliorer :
- Sécurisation du JavaScript : il est bien trop facile de s'ajouter des points sans regarder la vidéo.
- Editeur d'article plus complet afin d'avoir des articles avec une belle mise en page.
- Développement d'une régie publiciataire (ou utilisation de celle de Google) afin d'ajouter des points après avoir vu une pub.

## Captures d'écran
### Première capture
![Capture d'écran 1](http://i.imgur.com/S2OE6Gn.jpg)
### Seconde capture
![Capture d'écran 2](http://i.imgur.com/vAOVS0a.jpg)
