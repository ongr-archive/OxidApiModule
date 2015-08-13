# OxidApiModule

Module for OXID that provides API access for checkout process

## Setup

 - Clone this repository into OXID modules directory `git clone git@github.com:ongr-io/OxidApiModule.git modules/ongr`
 - Enable module throught OXID backend.
 - Use API's!
 
## Provided REST API's

| Access URL                   | GET | POST | DELETE |
|------------------------------|-----|------|--------|
| /ongr/api/basket/            |  X  |   X  |    X   |
| /ongr/api/articles/          |  X  |      |        |
| /ongr/api/checkout/          |     |   X  |        |
| /ongr/api/checkout/delivery/ |  X  |   X  |        |
| /ongr/api/checkout/payment/  |  X  |   X  |        |
| /ongr/api/user/              |  X  |      |        |
| /ongr/api/user/check/        |  X  |      |        |
| /ongr/api/user/login/        |     |   X  |        |
| /ongr/api/user/register/     |     |   X  |        |

Happy resting!
