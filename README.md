# PHP Transmission API

**🚀 100% Compatible with Transmission RPC v18** - Supports all modern features from Transmission 4.1.0+

This library provides a complete, modern interface to the [Transmission](http://transmissionbt.com) BitTorrent client. It implements **100% of the official Transmission RPC specification v18** including all advanced features like labels, bandwidth groups, queue management, and protocol optimizations.

## ✨ Key Features

- **🎯 Complete RPC v18 Support**: All methods and fields from the latest Transmission RPC specification
- **🏷️ Labels & Organization**: Full torrent labeling system for better organization
- **📊 Bandwidth Groups**: Advanced bandwidth management with custom speed limits
- **⚡ Queue Management**: Complete control over download/upload queues
- **🔄 Protocol Optimizations**: Table format, recently-active filters, and more
- **🔧 Modern Session Control**: Sequential downloads, port testing, blocklist management
- **📱 Developer Friendly**: Clean API with full PHP 8.4 and PHPUnit 12 support

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
[`Transmission\Model\Torrent`](https://github.com/transmission-php/transmission-php/tree/master/src/Transmission/Model/Torrent.php).

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

## 🚀 Modern Features (RPC v18)

### Labels & Organization

```php
// Add torrents with labels
$torrent = $transmission->addWithLabels('/path/to/file.torrent', false, null, ['linux', 'iso', 'official']);

// Get and modify labels
$labels = $torrent->getLabels();
$transmission->setTorrent($torrent, ['labels' => ['updated', 'labels']]);
```

### Queue Management

```php
// Control download/upload queue position
$transmission->queueMoveTop($torrent);      // Move to top
$transmission->queueMoveUp([$torrent1, $torrent2]); // Move up
$transmission->queueMoveDown($torrent);     // Move down
$transmission->queueMoveBottom($torrent);   // Move to bottom

// Get queue position
$position = $torrent->getQueuePosition();
```

### Bandwidth Groups

```php
// Create bandwidth groups for different types of content
$transmission->setBandwidthGroup('gaming', [
    'speed-limit-down' => 5000,  // 5MB/s download
    'speed-limit-up' => 1000,    // 1MB/s upload
    'speed-limit-down-enabled' => true,
    'speed-limit-up-enabled' => true
]);

// Assign torrents to bandwidth groups
$transmission->setTorrent($torrent, ['group' => 'gaming']);

// Get all bandwidth groups
$groups = $transmission->getBandwidthGroups();
```

### Advanced Torrent Information

```php
// Get detailed torrent information
$availability = $torrent->getAvailability();      // Piece availability
$magnetLink = $torrent->getMagnetLink();          // Magnet link
$fileCount = $torrent->getFileCount();            // Number of files
$isStalled = $torrent->isStalled();               // Stalled status
$errorInfo = $torrent->getErrorString();          // Error details

// File information with piece ranges (RPC v18)
$files = $torrent->getFiles();
foreach ($files as $file) {
    $beginPiece = $file->getBeginPiece();
    $endPiece = $file->getEndPiece();
}
```

### Protocol Optimizations

```php
// Use table format for better performance with large torrent lists
$torrents = $transmission->getTorrents(null, ['id', 'name', 'status'], 'table');

// Get only recently active torrents
$recentTorrents = $transmission->getRecentlyActive();

// Rename torrent paths
$result = $transmission->renamePath($torrent, 'old/folder', 'new_folder');
```

### Advanced Session Features

```php
$session = $transmission->getSession();

// Enable sequential download by default
$session->setSequentialDownload(true);

// Set default trackers for all torrents
$session->setDefaultTrackers("udp://tracker1.example.com:8080\n\nudp://tracker2.example.com:8080");

// Get version information
$version = $session->getRpcVersionSemver(); // "5.4.0"
$transmissionVersion = $session->getVersion(); // "4.1.0 (abc123)"

// Test port connectivity
$portTest = $transmission->testPort('ipv4');
$isPortOpen = $portTest['port-is-open'];

// Update blocklist
$newSize = $transmission->updateBlocklist();

$session->save();
```

### Free Space with Total Capacity

```php
$freeSpace = $transmission->getFreeSpace('/downloads');
$available = $freeSpace->getSize();     // Available space
$total = $freeSpace->getTotalSize();    // Total capacity (RPC v17+)
$used = $total - $available;            // Used space
```

## Testing

### Local Testing

```bash
# Install dependencies
composer install

# Run all tests
composer phpunit

# Run static analysis
composer phpstan

# Check code style
composer php-cs-fixer

# Run security audit
composer audit

# Pre-commit checks (recommended before committing)
.github/scripts/pre-commit.sh
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
