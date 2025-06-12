# GiveDirectly Transfer Generator

This is a PHP implementation of a Transfer Generator for GiveDirectly. The system accepsts an input data that includes the following details;

Cadence: this could be weekly, monthly, quarterly, biannually(every 6 months) or annually
Date: The date of first transfer
Amount: Amount to be transferred
Number of transfers: Number of transfers to be processed

The system returns an array of details for each scheduled transfer. For example, if we supply the input with the following details;
Cadence: "monthly"
Date: 2024-03-20
Amount: 100.00
Number of transfers: 3

The expected out put would be an array ;
[
    ['date' => '2024-03-20', 'amount' => 100.00],
    ['date' => '2024-04-20', 'amount' => 100.00],
    ['date' => '2024-05-20', 'amount' => 100.00],
]

## Assumptions

In this implementation I have made the following assumptions;
 - For monthly transfers that fall on a day that is non-existent in the month, the last day of that month is used. This means if the first transfer for a monthly cadence was processed on January 30, 2025, the next transfer would be processed on February 28, 2025 just because February 30 does not exist.
 

## Requirements

- [Docker](https://www.docker.com/) and Docker Compose
- (Optional) PHP 8.2+ and Composer, if you prefer to run the app without Docker

## Installation

This project uses Docker to ensure consistent environments.

To install dependencies:

```bash
make install
```

> This command runs Composer inside a Docker container. Make sure Docker is installed and running.

### Local (non-Docker) alternative

If you prefer to use your local PHP and Composer installation:

```bash
composer install
```

> Note: Your local environment must match the PHP version and extensions defined in the container.



## Testing

Run the test suite:

- Using Docker
```bash
make test
```
- Local(non-Docker) alternative
```bash
composer test
```
