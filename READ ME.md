## README

# Utilisation du serveur Apache avec Symfony

Ce guide vous explique comment configurer un serveur Apache pour votre application Symfony en utilisant le pack `symfony/apache-pack`.

## Prérequis

Avant de commencer, assurez-vous d'avoir un environnement de développement local configuré, tel que WAMP, XAMP, ou MAMP, qui inclut un serveur Apache.

**Important :** Le module `mod_rewrite` d'Apache doit être activé, car Symfony en dépend pour la gestion des routes.

## Installation

Pour installer le pack Apache dans votre projet Symfony, exécutez la commande suivante :

```bash
composer require symfony/apache-pack
```

