# Module Chalhoub ShopFinder

    ``chalhoub/module-shopfinder``

- [Main Functionalities](#markdown-header-main-functionalities)
- [Installation](#markdown-header-installation)
- [Configuration](#markdown-header-configuration)
- [Specifications](#markdown-header-specifications)
- [Attributes](#markdown-header-attributes)


## Main Functionalities
Chalhoub Shop Finder module

## Installation

### Prerequisite
Docker is a requirement for this project to run (https://docs.docker.com/get-docker/)

#### Installation Steps

1. Clone this repository.
2. Open your terminal and change directory to chalhoub project folder (`cd chalhoub`)
3. Update your host file to magento2.local
4. Run `docker-compose up -d`
5. Open your browser and navigate to http://magento2.local
6. Please note that 2FA authentication has been disabled for admin login
   ```
   admin_url : http://magento2.local/admin
   admin_username: john.smith
   admin_password: password123
   ```
##### NB: To install https, you can run `bin/setup-ssl magento2.local` and then import the corresponding certificate into your browser

## Install ShopFinder Module

1. Run `bin/composer config repositories.0 vcs https://github.com/purplebolt/module-shopfinder.git`
2. Run `bin/composer require purplebolt/shopfinder`
3. Run deployment commands
   ```
    bin/magento setup:upgrade
    bin/magento setup:di:compile
    bin/magento c:f
   ```

## Specifications

### GraphQL Endpoint https://magento2.local/graphql

- Shop Creation
  ```
  mutation{
    addShop(
      input: {
        shop_name: "Stoic Accessories"
        identifier: "SHP-6920"
        country: "GB"
        shop_image: "there-is-no-image-here.png"
       }
     ) {
       shop {
         shop_image
         country
         shop_name
       }
     }
  }
  ``` 

 - Fetch ALL Shops
    ```
    {
       listShops(
        pageSize: 10
        currentPage: 1
      ) {
        total_count
        items {
          shop_name
          identifier
          country
          shop_image
        }
      }
    }
    ```

- Get Info of Single Shop using Identifier

  ```
    {
       listShops(
        pageSize: 1
        filter: {identifier : {eq:"SHP-4021"}}
      ) {
        total_count
        items {
          shop_name
          identifier
          country
          shop_image
        }
      }
    }
  ```
    
 - Update a shop information
   ```
   mutation {
      editShop(
       id: 2,  
       input: {
         shop_name: "Stoic Shop"
         identifier: "SHP-4024"
       }
     ) {
       shop {
         shop_name
         identifier
         shop_id
       }
     }
   }
   
   ``` 

 - Deleting a shop
  
  ```
  mutation {
    deleteShop(id: 1)
  } 
  ```  
   




