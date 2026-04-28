{ pkgs }: {
  deps = [
    pkgs.php82
    pkgs.php82Extensions.mysql
    pkgs.php82Extensions.curl
    pkgs.php82Extensions.openssl
    pkgs.php82Extensions.mbstring
    pkgs.php82Extensions.dom
    pkgs.php82Extensions.xml
    pkgs.php82Extensions.zip
    pkgs.composer
    pkgs.nodejs_20
    pkgs.mysql80
  ];
}
