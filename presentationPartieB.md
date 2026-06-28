# PHP Avancé — Fonctions modernes & Écosystème

> Formation Technique · 2025

---

## 01 — Fonctions Anonymes, Closures & Arrow Functions

> Fonctions sans nom, capture de contexte, syntaxe courte

---

### Fonctions Anonymes

Une fonction sans nom, assignée à une variable ou passée en argument.

```php
// Assignée à une variable
$saluer = function($nom) {
    return "Bonjour, $nom !";
};

echo $saluer("Alice");

// Passée comme argument
usort($arr, function($a, $b) {
    return $a - $b;
});
```

**Cas d'usage** : Callbacks, tris personnalisés, handlers d'événements

**Avantage clé** : Encapsulation locale — la logique reste là où elle est utilisée

> ⚡ Disponible depuis PHP 5.3

---

### Closures — Capture de contexte

Le mot-clé `use` permet de capturer des variables extérieures à la fonction.

```php
$taxe = 0.20;

// Capture par valeur
$prixTTC = function($ht) use ($taxe) {
    return $ht * (1 + $taxe);
};

// Capture par référence
$compteur = 0;
$incrementer = function() use (&$compteur) {
    $compteur++;
};
```

| Syntaxe | Comportement |
|---|---|
| `use($var)` | Copie la valeur au moment de la définition |
| `use(&$var)` | Référence directe — les modifications sont visibles en dehors |

> `bindTo()` permet de lier une closure à un objet (`$this`)

---

### Arrow Functions (`fn =>`)

Introduites en PHP 7.4 — syntaxe compacte, capture automatique du scope parent.

```php
// Avant PHP 7.4
$mult = 3;
$fn = function($n) use ($mult) {
    return $n * $mult;
};

// Avec Arrow Function
$mult = 3;
$fn = fn($n) => $n * $mult;
```

- ✅ Capture automatique du scope parent (pas de `use`)
- ✅ Expression unique — pas de bloc `{ }` ni de `return` explicite
- ✅ Idéal pour `array_map` / `array_filter` / `usort`
- ❌ Pas de capture par référence avec `&`

---

## 02 — Fonctions Natives de Tableaux `array_*`

> Transformer, filtrer, trier et réduire sans écrire de boucles

---

### Les incontournables : map · filter · reduce

```php
// array_map() — Transforme chaque élément
$doubles = array_map(
    fn($n) => $n * 2,
    $nombres
);
// [1,2,3] → [2,4,6]

// array_filter() — Conserve les éléments selon un critère
$pairs = array_filter(
    $nombres,
    fn($n) => $n % 2 === 0
);
// [1,2,3,4] → [2,4]

// array_reduce() — Réduit le tableau à une valeur unique
$total = array_reduce(
    $prix,
    fn($acc, $p) => $acc + $p,
    0
);
// [1,2,3] → 6
```

---

### Autres fonctions essentielles

| Fonction | Description | Exemple |
|---|---|---|
| `usort()` | Tri personnalisé avec callback | `usort($u, fn($a,$b) => $a['age'] - $b['age']);` |
| `array_search()` | Retourne la clé du premier élément trouvé | `$key = array_search("PHP", $langues);` |
| `array_unique()` | Supprime les doublons | `$clean = array_unique($avec_doublons);` |
| `array_merge()` | Fusionne plusieurs tableaux | `$all = array_merge($arr1, $arr2);` |
| `array_keys()` | Retourne toutes les clés | `$keys = array_keys($assoc);` |
| `array_chunk()` | Divise en sous-tableaux de taille n | `$pages = array_chunk($items, 10);` |

---

## 03 — Composer — Gestionnaire de Dépendances

> Installer, mettre à jour et autoloader les packages PHP

---

### Rôle & Fonctionnement

Composer est le gestionnaire de dépendances standard de PHP. Il lit le fichier `composer.json` pour télécharger les packages requis et génère un **autoloader PSR-4** prêt à l'emploi.

**Fichiers clés**

| Fichier | Rôle |
|---|---|
| `composer.json` | Déclaration des dépendances et métadonnées du projet |
| `composer.lock` | Versions exactes installées — garantit la reproductibilité |
| `vendor/` | Dossier contenant tous les packages installés + l'autoloader |

**Commandes essentielles**

```bash
composer init                    # Initialise un nouveau projet
composer require vendor/package  # Installe un package et l'ajoute à composer.json
composer install                 # Installe les dépendances depuis composer.lock
composer update                  # Met à jour les packages selon les contraintes de version
```

---

### Anatomie d'un `composer.json`

```json
{
  "name": "monprojet/app",
  "require": {
    "php": ">=8.1",
    "monolog/monolog": "^3.0"
  },
  "require-dev": {
    "phpunit/phpunit": "^10.0"
  },
  "autoload": {
    "psr-4": {
      "App\\": "src/"
    }
  }
}
```

| Clé | Explication |
|---|---|
| `require` | Dépendances de production. Contraintes : `^`, `~`, `>=` |
| `require-dev` | Outils de développement uniquement (tests, debug). Non installés en prod. |
| `autoload psr-4` | Mappe un namespace PHP à un dossier — Composer génère le `require` automatique. |
| `^3.0` | Compatible `3.x.x` mais pas `4.0`. `~` : version mineure compatible. |

---

## 04 — Packagist.org — L'écosystème des packages PHP

> Le dépôt central public — des milliers de packages prêts à installer

---

### La plateforme

| | |
|---|---|
| **400 000+** packages disponibles | Gratuit, Open Source & public |
| Intégré nativement à Composer | Webhook GitHub pour auto-publication |

### Comment ça fonctionne ?

1. Le développeur publie son package sur GitHub/GitLab avec un `composer.json`
2. Il enregistre son dépôt sur **packagist.org** (webhook GitHub optionnel)
3. Packagist indexe les versions (tags Git = versions Composer)
4. N'importe qui peut faire `composer require vendor/package` pour l'installer

### Packages populaires

- `monolog/monolog` — Logging
- `symfony/console` — CLI
- `guzzlehttp/guzzle` — HTTP client
- `laravel/framework` — Framework MVC
- `phpunit/phpunit` — Tests unitaires

---

## Synthèse

| Sujet | Points clés |
|---|---|
| **Fonctions Anonymes & Closures** | Fonctions de première classe, capture du scope avec `use`/`$this`, idéales pour les callbacks |
| **Arrow Functions (`fn =>`)** | Syntaxe courte PHP 7.4+, capture automatique du parent scope, expression unique |
| **Fonctions Array Natives** | `array_map` / `filter` / `reduce` / `usort` — traitement fonctionnel sans boucles explicites |
| **Composer** | Gestionnaire de dépendances, autoloader PSR-4, `composer.json` + `composer.lock` |
| **Packagist.org** | 400 000+ packages indexés, publication via webhook GitHub, intégration native Composer |