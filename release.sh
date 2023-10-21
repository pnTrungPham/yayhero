echo "Generating build directory..."
rm -rf "$(pwd)/release"
mkdir -p "$(pwd)/release"

echo "Install JS dependencies..."
cd apps
npm install

echo "Running JS build..."
npm run build

echo "Syncing files..."
cd ..
rsync -rc --exclude-from="$(pwd)/.distignore" "$(pwd)/" "$(pwd)/release/yaymail-addon-for-woocommerce-subscriptions" --delete --delete-excluded

echo "Generating zip file..."
cd release
zip -q -r "yaymail-addon-for-woocommerce-subscriptions.zip" "yaymail-addon-for-woocommerce-subscriptions/"
rm -rf yaymail-addon-for-woocommerce-subscriptions
echo "Generated release file"

echo "Build successfully"