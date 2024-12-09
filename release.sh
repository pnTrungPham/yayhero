#!/bin/bash

echo "Generating build directory..."
rm -rf "$(pwd)/release"
mkdir -p "$(pwd)/release"

echo "Syncing files..."
rsync -rc --exclude-from="$(pwd)/.distignore" "$(pwd)/" "$(pwd)/release/rapid-file-manager" --delete --delete-excluded

echo "Generating zip file..."
cd "$(pwd)/release"
zip -q -r "rapid-file-manager.zip" "rapid-file-manager/"
rm -rf rapid-file-manager
echo "Generated release file"

echo "Build successful"