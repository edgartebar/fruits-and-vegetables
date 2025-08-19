# 🍎🥕 Fruits and Vegetables

## 🎯 Goal
We want to build a service which will take a `request.json` and:
* Process the file and create two separate collections for `Fruits` and `Vegetables`
* Each collection has methods like `add()`, `remove()`, `list()`;
* Units have to be stored as grams;
* Store the collections in a storage engine of your choice. (e.g. Database, In-memory)
* Provide an API endpoint to query the collections. As a bonus, this endpoint can accept filters to be applied to the returning collection.
* Provide another API endpoint to add new items to the collections (i.e., your storage engine).
* As a bonus you might:
  * consider giving an option to decide which units are returned (kilograms/grams);
  * how to implement `search()` method collections;
  * use latest version of Symfony's to embed your logic 

### ✔️ How can I check if my code is working?
You have two ways of moving on:
* You call the Service from PHPUnit test like it's done in dummy test (just run `bin/phpunit` from the console)

or

* You create a Controller which will be calling the service with a json payload

## 💡 Hints before you start working on it
* Keep KISS, DRY, YAGNI, SOLID principles in mind
* We value a clean domain model, without unnecessary code duplication or complexity
* Think about how you will handle input validation
* Follow generally-accepted good practices, such as no logic in controllers, information hiding (see the first hint).
* Timebox your work - we expect that you would spend between 3 and 4 hours.
* Your code should be tested
* We don't care how you handle data persistence, no bonus points for having a complex method

## When you are finished
* Please upload your code to a public git repository (i.e. GitHub, Gitlab)

## 🐳 Docker image
Optional. Just here if you want to run it isolated.

### 📥 Pulling image
```bash
docker pull tturkowski/fruits-and-vegetables
```

### 🧱 Building image
```bash
docker build -t tturkowski/fruits-and-vegetables -f docker/Dockerfile .
```

### 🏃‍♂️ Running container
```bash
docker run -it -w/app -v$(pwd):/app tturkowski/fruits-and-vegetables sh 
```

### 🛂 Running tests
```bash
docker run -it -w/app -v$(pwd):/app tturkowski/fruits-and-vegetables bin/phpunit
```

### ⌨️ Run development server
```bash
docker run -it -w/app -v$(pwd):/app -p8080:8080 tturkowski/fruits-and-vegetables php -S 0.0.0.0:8080 -t /app/public
# Open http://127.0.0.1:8080 in your browser
```

### Edit: Considerations

#### New Routes Added:

1. **List items with filters**  
   **Method:** `GET`  
   **Route:** `/items`  
   **Optional Parameters:**
  - `type` (string): Filter by item type (`fruit` or `vegetable`).
  - `name` (string): Filter by name or partial match.
  - `gt` (int): Filter items with weight greater than or equal to the specified value.
  - `lt` (int): Filter items with weight less than or equal to the specified value.
  - `units` (string): Specify the weight unit returned (`kg` or `g`).

2. **Search items with advanced filters**  
   **Method:** `GET`  
   **Route:** `/items/search`  
   **Optional Parameters:**
  - `type` (string): Filter by item type (`fruit` or `vegetable`).
  - `name` (string): Filter by name or partial match.
  - `orderBy` (string): Sort results by a specific field (`name`, `weight`, etc.).
  - `order` (string): Specify the sorting order (`ASC` or `DESC`).
  - `limit` (int): Limit the number of results returned.
  - `offset` (int): Specify the offset for pagination.

3. **Add a new item**  
   **Method:** `POST`  
   **Route:** `/items`  
   **Request Body:**
   ```json
   {
       "type": "fruit", // or "vegetable"
       "name": "Tomato",
       "weight": 150 // in grams
   }

#### Run application
I added a new docker-compose file a Dockerfile file i wasn't able to pull the tturkowski/fruits-and-vegetables image.
```bash:
docker-compose up -d
```

### Ingest the sample data:
```bash
bin/console market:import-data
```

### Run tests:
```bash
docker exec -it web /bin/bash;
bin/phpunit --testsuite functional
bin/phpunit --testsuite unit
```



