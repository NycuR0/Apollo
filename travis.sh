#!/bin/bash
find . -name "*.php" -print0 | xargs -0 -n1 php -l || exit 1
echo -e "ms\nstop\n\n" | php src/pocketmine/PocketMine.php --no-wizard
if ls plugins/Apollo/Apollo*.phar >/dev/null 2>&1; then
    echo "Apollo.phar successfully created!"
fi
