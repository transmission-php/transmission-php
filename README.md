# PHP Transmission API

[![Build Status](https://travis-ci.org/transmission-php/transmission-php.png)](https://travis-ci.org/transmission-php/transmission-php)

This library provides an interface to the [Transmission](http://transmissionbt.com)
bit-torrent downloader. It provides means to get and remove torrents from
the downloader as well as adding new torrents to the download queue.

## Installation

Installation with [Composer](https://getcomposer.org):

```
composer require transmission-php/transmission-php
```

## Usage

Using the library is as easy as installing it:

```php
<?php
use Transmission\Transmission;

$transmission = new Transmission();

// Getting all the torrents currently in the download queue
$torrents = $transmission->all();

// Getting a specific torrent from the download queue
$torrent = $transmission->get(1);

// (you can also get a torrent by the hash of the torrent)
$torrent = $transmission->get(/* torrent hash */);

// Adding a torrent to the download queue
$torrent = $transmission->add(/* path to torrent */);

// Removing a torrent from the download queue
$torrent = $transmission->get(1);
$transmission->remove($torrent);

// Or if you want to delete all local data too
$transmission->remove($torrent, true);

// You can also get the Trackers that the torrent currently uses
// These are instances of the Transmission\Model\Tracker class
$trackers = $torrent->getTrackers();

// You can also get the Trackers statistics and info that the torrent currently has
// These are instances of the Transmission\Model\trackerStats class
$trackerStats = $torrent->getTrackerStats();

// To get the start date/time of the torrent in UNIX Timestamp format
$startTime = $torrent -> getStartDate();

// To get the number of peers connected
$connectedPeers = $torrent -> getPeersConnected();

// Getting the files downloaded by the torrent are available too
// These are instances of Transmission\Model\File
$files = $torrent->getFiles();

// You can start, stop, verify the torrent and ask the tracker for
// more peers to connect to
$transmission->stop($torrent);
$transmission->start($torrent);
$transmission->start($torrent, true); // Pass true if you want to start the torrent immediatly
$transmission->verify($torrent);
$transmission->reannounce($torrent);
```

To find out which information is contained by the torrent, check
[`Transmission\Model\Torrent`](https://github.com/transmission-php/transmission-php/tree/master/lib/Transmission/Model/Torrent.php).

By default, the library will try to connect to `localhost:9091`. If you want to
connect to another host or post you can pass those to the constructor of the
`Transmission` class:

```php
<?php
use Transmission\Transmission;

$transmission = new Transmission('example.com', 33);

$torrents = $transmission->all();
$torrent  = $transmission->get(1);
$torrent  = $transmission->add(/* path to torrent */);

// When you already have a torrent, you don't have to pass the client again
$torrent->delete();
```

It is also possible to pass the torrent data directly instead of using a file
but the metadata must be base64-encoded:

```php
<?php
$torrent = $transmission->add(/* base64-encoded metainfo */, true);
```

If the Transmission server is secured with a username and password you can
authenticate using the `Client` class:

```php
<?php
use Transmission\Client;
use Transmission\Transmission;

$client = new Client();
$client->authenticate('username', 'password');
$transmission = new Transmission();
$transmission->setClient($client);
```

Additionally, you can control the actual Transmission setting. This means
you can modify the global download limit or change the download directory:

```php
<?php
use Transmission\Transmission;

$transmission = new Transmission();
$session = $transmission->getSession();

$session->setDownloadDir('/home/foo/downloads/complete');
$session->setIncompleteDir('/home/foo/downloads/incomplete');
$session->setIncompleteDirEnabled(true);
$session->save();
```

## Testing

Testing is done using [PHPUnit](https://github.com/sebastianbergmann/phpunit). To
test the application, you have to install the dependencies using Composer before
running the tests:

```bash
$ composer phpunit
```

## Original author

This projet is a fork from https://github.com/kleiram/transmission-php/

## License

This library is licensed under the BSD 2-clause license.

    Copyright (c) 2014, Ramon Kleiss <ramonkleiss@gmail.com>
    All rights reserved.

    Redistribution and use in source and binary forms, with or without
    modification, are permitted provided that the following conditions are met:

    1. Redistributions of source code must retain the above copyright notice, this
       list of conditions and the following disclaimer.
    2. Redistributions in binary form must reproduce the above copyright notice,
       this list of conditions and the following disclaimer in the documentation
       and/or other materials provided with the distribution.

    THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
    ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
    WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
    DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR
    ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
    (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
    LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
    ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
    (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
    SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.

    The views and conclusions contained in the software and documentation are those
    of the authors and should not be interpreted as representing official policies,
    either expressed or implied, of the FreeBSD Project.
