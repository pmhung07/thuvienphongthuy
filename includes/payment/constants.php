<?php
//CẤU HÌNH TÀI KHOẢN (Configure account)
define('EMAIL_BUSINESS','leminhdzung1980@gmail.com');//Email Bảo kim
define('MERCHANT_ID','18155');                // Mã website tích hợp
define('SECURE_PASS','2043a15fb2e46472');   // Mật khẩu

// Cấu hình tài khoản tích hợp
define('API_USER','leminhdung');  //API USER
define('API_PWD','Q90wSnexJ9fa1yX5PZjUihIrK1CbV');       //API PASSWORD
define('PRIVATE_KEY_BAOKIM','-----BEGIN PRIVATE KEY-----
MIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQC2W4Mpyraxhmho
sMq1Wm4nB74SlshVXjchOuJRSheoeDsSoOiH0YjFGtA95piUaeYjMH/x7KQACscI
UqyjiuyKOXy+so7sb9v/PGErhMSkirGKLfJGolCKcvHovQrgxLPv7HUMyRfQjqMs
rqBKEbqUbjqKHZqj/TdIATMjTr69WoEmwGyKozc+mj51b2YDTX2r/Z0in4LShgjI
J1oE6J5EwOmYJv+uZF2i85TqPh/eSz55uOJIlnI6cRok0R9wJdgu3nSnvgdVv7ia
3rdiOTw+kzJ2uy1RIAa2BnveSByXKytr8DrhZVlCP9YYOOIBLkeMAw9jaNogqjv6
xpxqN06zAgMBAAECggEBAINQqMX6dM6nhB4HWSF46iNu/t9x9vcKblaeiYSR/zFQ
yvEiL/BF4eBV66j3md4d2Bx0+11h08M3/5Utu6XVD3qF5R+Jg0QdVOWaPDrTU6tN
OIXRikp07dyU40B+iQvMeeqGcs9vK5gCbtxpL4HG/H2QVtVIdigq2pkeTA3b0ZyW
DYZBPBb4hot8rDWL9HGdGJ5rG2t3UHXlyAtMBAZZENQdIofErkERS50iYe9kcvTj
aOPFY9ze2Y37SS87T7QUUDmQslLD/w0hfEChXJAN1zmTjVVN4qt0BYH71GgEfrPA
OhTHUjRmtPt3QA4A89vdIG3y9bIuYEYJWWR2IJEilkECgYEA2QW1xdAxaSgimFtO
XylzHu1XByD94SGOYqTE/pxpNp5VV1T4E3v15KA105VUUHwa8t1SQ7adKAcAsSy5
HFqV/JmpKPJstvT5wtVTXVpmIk96j87/n0gL8xS9CWXA9WhW/CedEXHvJ90kUvB1
WQRd9UQ7PEjDVglneVQYxv5AO1MCgYEA1xv59UekTfzCY8OmdD0x6lY9pNFSaYC4
Y21IRMv45xJGwcgovnVtTX+JvpD/sNYPZC7fYeJxYDhT1Stir8Ab8zk/Gpjzda6N
gT2/qM8N/9b2tJWFc18+To/npWhzPbnX/74WUKEQaQy6zmy9/I7oSRBOoxXZ0oF0
GBrTihnFkyECgYARhH55qyZx4IV6WtRmpgfe1TWTI7yacYT2vWoRSzrK59jnpboo
iHb+r1fo7kLSBFKAjBDZ2mGxG2+Y3Y1LlpxIuXaIEZlo4zlN2r5R6LwZxOSVuxWz
G7OrOV9Q5N/Ab12mGOR6xgGR7C3EbBhsyQd0hr9pTE5IIZYymvEtDtTMdQKBgQCC
DYkPUbQ17nZ8qMKPjpwKKP/2ERQ5cziH7H+AEK44zmT3LhPsKsTd0RkvnSzp9lGx
6WDnJmgTm5qbzDJLPePoJplPdF/lq5YkKHgjEKRPJOFdhvT7Lv9Vsk2EROU/0YeV
OJD3SJnKWYbr3PT0qFYqLnDMyx451kihdj6lRTWd4QKBgC7pIAiW6S9R/qj0RxMn
UIGSKz8gpTJG7gWL2gdQQrcOrUoF+FwMt/KQCHQudM194gkf3+hBKFPPgYHBqyU/
plvNLd/C3ssSWY2OehUI4zX/7Ey/+2JN4IWq4/Ofhw2LpvfRZz3gfgt1LpAdyc6r
Vt6xacZbaLu6/ZQPd/agzgwD
-----END PRIVATE KEY-----');

define('BAOKIM_API_SELLER_INFO','/payment/rest/payment_pro_api/get_seller_info');
define('BAOKIM_API_PAY_BY_CARD','/payment/rest/payment_pro_api/pay_by_card');
define('BAOKIM_API_PAYMENT','/payment/order/version11');

define('BAOKIM_URL','https://www.baokim.vn');
//define('BAOKIM_URL','http://kiemthu.baokim.vn');

//Phương thức thanh toán bằng thẻ nội địa
define('PAYMENT_METHOD_TYPE_LOCAL_CARD', 1);
//Phương thức thanh toán bằng thẻ tín dụng quốc tế
define('PAYMENT_METHOD_TYPE_CREDIT_CARD', 2);
//Dịch vụ chuyển khoản online của các ngân hàng
define('PAYMENT_METHOD_TYPE_INTERNET_BANKING', 3);
//Dịch vụ chuyển khoản ATM
define('PAYMENT_METHOD_TYPE_ATM_TRANSFER', 4);
//Dịch vụ chuyển khoản truyền thống giữa các ngân hàng
define('PAYMENT_METHOD_TYPE_BANK_TRANSFER', 5);

?>