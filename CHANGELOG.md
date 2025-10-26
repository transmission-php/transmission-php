# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [3.0.0]

🚀 **Major Release: 100% Transmission RPC v18 Compatibility**

This release represents a complete overhaul of the library with full support for modern Transmission features and PHP 8.4 compatibility.

### ⚡ Breaking Changes
- **Minimum PHP Version**: Now requires PHP 8.0+ (was PHP 7.4)
- **Directory Structure**: Moved source code from `lib/` to `src/` (API unchanged)
- **PHPUnit**: Now requires PHPUnit 12+ for development

### 🎯 Major New Features

#### **100% RPC v18 Compatibility**
- **Labels Support**: Full torrent labeling system
  - `addWithLabels($torrent, $metainfo, $savepath, $labels)` method
  - `getLabels()`, `setLabels()` on torrent objects
  - Label-based organization and filtering

- **Bandwidth Groups**: Advanced bandwidth management
  - `getBandwidthGroups()`, `setBandwidthGroup()` methods
  - Speed limits and session honor settings
  - Per-torrent bandwidth assignment via `group` field

- **Queue Management**: Complete queue control
  - `queueMoveTop()`, `queueMoveUp()`, `queueMoveDown()`, `queueMoveBottom()`
  - Support for individual torrents or arrays
  - Queue position tracking

- **Protocol Optimizations**:
  - Table format: `getTorrents($ids, $fields, 'table')` for efficiency
  - Recently active filter: `getRecentlyActive()` method
  - Path renaming: `renamePath($torrent, $oldPath, $newPath)`

#### **Extended Model Support**
- **Torrent Model**: +17 new fields
  - `availability`, `fileCount`, `group`, `labels`, `magnetLink`
  - `metadataPercentComplete`, `primaryMimeType`, `trackerList`
  - `queuePosition`, `percentComplete`, `etaIdle`
  - `editDate`, `addedDate`, `activityDate`, `isStalled`
  - `error`, `errorString`, `sequentialDownload`

- **File Model**: +2 new fields (`beginPiece`, `endPiece`)
- **Session Model**: +15 new fields including version info, network settings
- **FreeSpace Model**: +1 new field (`totalSize`)
- **Tracker Model**: +1 new field (`sitename`)

#### **New BandwidthGroup Model**
- Complete model for bandwidth group management
- Speed limit configuration
- Session honor settings
- Save functionality

### 🔧 Advanced Session Features
- **Sequential Downloads**: `setSequentialDownload()` method
- **Default Trackers**: Global tracker configuration
- **Port Testing**: `testPort('ipv4'/'ipv6')` method
- **Blocklist Management**: `updateBlocklist()` method
- **Session Control**: `closeSession()` for clean shutdown
- **Version Information**: RPC version and semver support
