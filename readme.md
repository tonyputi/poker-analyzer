## Introduction

Poker Analyzer is a software based on PHP and Laravel. The scope of this software is to provide a smart way to analyze each hand of each player and provide a result about the winner.

There are a lot of way to do this such as brute force with huge and ugly code but I found a very intresting article about [a poker analyzer in javascript unsing bit math!](https://www.codeproject.com/Articles/569271/A-Poker-hand-analyzer-in-JavaScript-using-bit-math) that promise to solve the problem using bit math. Amazing!!!

## The idea

The main idea is to use bit math to map each hand of each player to binary value and manipulate it to figure out wich type of rank each player has on his hand. Than another function will compare the rank of each player and decide who is the winner.

The following schema will help to understand the logic under the evalute/analyze process.
Anyway for furture informations please referr to the article mentioned above that will provide a complete and fully understandeable explaination about the evalute process.

The class that acts as analizer is located at [app/Services/Analyzer.php](https://github.com/tonyputi/poker-analyzer/blob/master/app/Services/Analyzer.php)

```
   A       K       Q       J       T       9       8       7       6       5       4       3       2

B B B B|B B B B|B B B B|B B B B|B B B B|B B B B|B B B B|B B B B|B B B B|B B B B|B B B B|B B B B|B B B B 

Royal flush
0 0 0 1|0 0 0 1|0 0 0 1|0 0 0 1|0 0 0 1|0 0 0 0|0 0 0 0|0 0 0 0|0 0 0 0|0 0 0 0|0 0 0 0|0 0 0 0|0 0 0 0

Straight flush
0 0 0 0|0 0 0 0|0 0 0 0|0 0 0 0|0 0 0 0|0 0 0 1|0 0 0 1|0 0 0 1|0 0 0 1|0 0 0 1|0 0 0 0|0 0 0 0|0 0 0 0

Four of a kind
0 0 0 0|0 0 0 0|1 1 1 1|0 0 0 0|0 0 0 1|0 0 0 0|0 0 0 0|0 0 0 0|0 0 0 0|0 0 0 0|0 0 0 0|0 0 0 0|0 0 0 0

Full house
0 0 0 0|0 0 0 0|0 0 0 0|0 0 1 1|0 1 1 1|0 0 0 0|0 0 0 0|0 0 0 0|0 0 0 0|0 0 0 0|0 0 0 0|0 0 0 0|0 0 0 0

Flush
0 0 0 0|0 0 0 1|0 0 0 0|0 0 0 1|0 0 0 0|0 0 0 0|0 0 0 0|0 0 0 1|0 0 0 0|0 0 0 1|0 0 0 0|0 0 0 0|0 0 0 1

Straight
0 0 0 0|0 0 0 0|0 0 0 0|0 0 0 1|0 0 0 1|0 0 0 1|0 0 0 1|0 0 0 1|0 0 0 0|0 0 0 0|0 0 0 0|0 0 0 0|0 0 0 0

Three of a kind
0 0 0 0|0 0 0 0|0 0 0 0|0 0 0 0|0 0 0 0|0 0 0 0|0 0 0 0|0 0 0 0|0 1 1 1|0 0 0 0|0 0 0 1|0 0 0 0|0 0 0 1

Two pair
0 0 1 1|0 0 0 0|0 0 0 0|0 0 0 0|0 0 0 0|0 0 0 0|0 0 0 0|0 0 0 0|0 0 0 0|0 0 1 1|0 0 0 0|0 0 0 0|0 0 0 1

One pair
0 0 0 0|0 0 1 1|0 0 0 0|0 0 0 0|0 0 0 0|0 0 0 0|0 0 0 0|0 0 0 1|0 0 0 0|0 0 0 1|0 0 0 0|0 0 0 0|0 0 0 1

High card
0 0 0 1|0 0 0 1|0 0 0 0|0 0 0 1|0 0 0 1|0 0 0 0|0 0 0 1|0 0 0 0|0 0 0 0|0 0 0 0|0 0 0 0|0 0 0 0|0 0 0 0
```

## Installation

To install the software please open a terminal and exec the following commands one by one

```
git clone git@github.com:tonyputi/poker-analyzer.git
cd poker-analyzer
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate
```

## Usage

You can use the software in two different ways.

### Command line

In this way the software will evalute the input file and print the results on the command line as a table.

```
php artisan poker:analyze docs/hands.txt
```

### Web browser

In this way a web user interface will serve the application

```
php artisan serve
```

1. Open your browser and go to http://127.0.0.1:8000
2. Click on register link on top-right corner and proceed to register a new user
3. Upload the hands.txt file, click on analyze button and wait. The results will be showed after process finish
