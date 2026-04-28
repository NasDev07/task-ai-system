{ pkgs }: {
  deps = [
    pkgs.php80
    pkgs.php80Extensions.mysql
    pkgs.php80Extensions.curl
    pkgs.php80Extensions.openssl
    pkgs.php80Extensions.mbstring
    pkgs.php80Extensions.dom
    pkgs.php80Extensions.xml
    pkgs.php80Extensions.zip
    pkgs.composer
    pkgs.nodejs_20
    pkgs.mysql80
  ];
}
