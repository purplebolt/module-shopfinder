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

1. Open your terminal and run `mkdir ~/chalhoub`
2. Run `cd ~/chalhoub`
3. Run `git clone https://github.com/purplebolt/chaloub-docker-container.git .` to clone docker git repo.
4. Update your host file by adding magento2.local
5. Run `docker-compose up -d`
6. Open your browser and navigate to http://magento2.local
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
        filter: {identifier : {eq:"SHP-6920"}}
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
       id: 1,  
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
  
