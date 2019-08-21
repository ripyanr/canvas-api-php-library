# Canvas API PHP Library

Contact: its-laravel-devs-l@uncg.edu

# Introduction

This package is a PHP library used to interact with the Canvas API.

## Scope

This package is not (yet) as a comprehensive interface with the Canvas API - it is not written to perform every conceivable API call to Canvas. Currently, this package suits the specific needs of UNC Greensboro's Canvas integrations, and performs only the functions necessary for day-to-day operations thereof.

It is intended for internal use - if you are external to UNCG please feel free to fork this package and modify it to suit your needs.

# Installation

1. `composer require 'uncgits/ccanvas-rest-client'`
2. Use one of the API calls built into the `Uncgits\Canvasrestclient\Canvasrestclient` class, or extend it and add your own. The standard API call is built in there. You'll have to find a way to call the setter methods to set the variables required to make the call - specific to your environment (e.g. urls, credentials, etc.)

# Version History

## 0.1

- first tagged release, but has a lot of stuff in it. first try at doing a lot of basic calls.
