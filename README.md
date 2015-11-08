#Recipe Finder Challenge

## Installing

for running tests insure that composer is run

	composer install
	
## Running Application

From the root directory run the following command

	php src/index.php <ingredients CSV> <recipes JSON>

replacng ingredients CSV with the path to the the a CSV file and recipes JSON with the path to the json file

example: 

	php src/index.php ./resources/fridge.csv ./resources/recipes.json

The above example will always return no result as the expiry dates provided are in the past. An example of a working test with valid dates can be found using the following example:

	php src/index.php ./resources/fridge2015.csv ./resources/recipes.json

## Problem
Given a list of items in the fridge (presented as a csv list), and a collection of recipes (a collection of JSON formatted recipes), produce a recommendation for what to cook tonight.
Program should be written to take two inputs; fridge csv list, and the json recipe data. How youchoose to implement this is up to you; you can write a console application which takes input filenames as command line args, or as a web page which takes input through a form.
The only rule is that it must run and return a valid result using the provided input data.

## Solution
Create a command line PHP application that uses PHPUnit testing. 

The Application will consist of 2 data services: 

1. Will parse and valid the CSV input file
2. Will parse and valid the JSON file

CSV Validation needs to ensure each row of the CSV contains 4 columns.

|Column|Type|
|:----:|:---|
|1|String|
|2|Int|
|3|String|
|4|DateTime|

JSON Validation needs to ensure the data structure is an array of objects.

Each object must contain 2 key/value pairs

|Key|Value|
|:----|:---|
|name|String|
|ingredients[]|Array of objects|

ingredients should not be empty (incomplete recipe). Each array row contains an object of 2 key/value pairs

|Key|Value|
|:----|:---|
|item|String|
|amount|Int|
|unit|String|



## Notes
- An ingredient that is past its usebydate cannot be used for cooking.
- If more than one recipe is found, then preference should be given to the recipe with theclosest usebyitem- If no recipe is found, the program should return “Order Takeout”- Program should be allinclusiveand a run script included- Please provide a complete copy of a git repository, or a link to a github/public repo	- We want to be able to see your commit history- Include unit testsUsing the sample input above, the program should return "salad sandwich".