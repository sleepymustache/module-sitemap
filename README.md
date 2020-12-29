# Sitemap Module 

* Date:    December 28, 2020
* Author:  Jaime A. Rodriguez <hi.i.am.jaime@gmail.com>
* Version: 1.0
* License: http://opensource.org/licenses/MIT

Manage links through simple JSON in the settings.php files. This JSON is compatible with the 
Navigation Class. The idea is to build the JSON based on the copydeck so you can easily link items
to pages defined in the copy and easily rename pages in one spot.

## Usage

~~~ php
    // Define a sitemap for use with the Navigation Module
    define('SITEMAP', '{
        "pages": [
            {
                "id": "1.0",
                "link": "/",
                "title": "Homepage",
                "pages": [
                    {
                        "id": "1.1",
                        "title": "Link 1",
                        "target": "",
                        "link": "#link1"
                    }, {
                        "id": "1.2",
                        "title": "Link 2",
                        "link": "#link2"
                    }, {
                        "id": "1.3",
                        "title": "Link 3",
                        "link": "#link3"
                    }
                ]
            }
        ]
    }');
~~~

~~~ html
    <!-- Create links using the "title" defined in the JSON -->
    {{ smlink 1.1 }}

    <!-- Create links where the text reads "click here" -->
    {{ smlink 1.1 "click here"}}
~~~

## Changelog

### Version 1.0

* Initial build