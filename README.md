**Show Bitcoin Info**
----
  Returns json data about a single user.

* **URL**

  /api/getBitcoinInfo?currency=:currency

* **Method:**

  `GET`
  
*  **URL Params**

   **Required:**
 
   `currency=[string]`

* **Data Params**

  None

* **Success Response:**

  * **Code:** 200 <br />
    **Content:** `{ 
        "current_rate": {
            "code": "EUR",
            "rate": "43,329.9745",
            "description": "Euro",
            "rate_float": 43329.9745
        },
        "min_rate": 33824.962,
        "max_rate": 42450.6185
    }`
 
* **Error Response:**

  * **Code:** 404 NOT FOUND <br />
    **Content:** `{
        "message": "Validation Faild",
        "errors": {
            "currency": [
                "The currency field is required."
            ]
        }
    }`


* **Sample Call:**

  ```javascript
    $.ajax({
      url: "/api/getBitcoinInfo?currency=eur",
      dataType: "json",
      type : "GET",
      success : function(r) {
        console.log(r);
      }
    });
  ```
