#!/bin/bash

echo "Generating build directory..."
rm -rf "$(pwd)/release"
mkdir -p "$(pwd)/release"

echo "Syncing files..."
rsync -rc --exclude-from="$(pwd)/.distignore" "$(pwd)/" "$(pwd)/release/rpfm" --delete --delete-excluded

echo "Generating zip file..."
cd "$(pwd)/release"
zip -q -r "rpfm.zip" "rpfm/"
rm -rf rpfm
echo "Generated release file"

echo "Build successful"