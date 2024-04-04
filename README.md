# Generators in PHP

Code examples shown during the Laravel Meetup about Generators.

[View the presentation](Presentation.pdf)

## Installation

Load dependencies via Composer:

```bash
composer install
```

## Usage

Run the `gen` command to see the list of commands:

```bash
php gen
```

See notes in the presentation slides regarding what commands to run.

### Run Benchmark

Uses the PhpBench tool to benchmark memory usage and processing time. Pass in the path to the file relative to the `tests` folder excluding the `Bench.php` suffix:

```bash
# Run tests/data/BasicImportBench.php
php gen bench data/BasicImport
```

### Generate Data

Generates random user data and outputs them as TSV:

```bash
# Generate 5000 rows and save to data/users.txt
php gen generate-data --length=5000 > data/users.txt
```

### Run Example

Runs a PHP file within the `src/Examples` folder:

```bash
# Run src/Example/yield.php
php gen run-example yield
```
