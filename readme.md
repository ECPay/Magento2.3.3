綠界科技 Magento 金流模組
===============
<p align="center">
    <!-- <img alt="Last Release" src="https://img.shields.io/github/release/ECPay/Magento_Payment.svg"> -->
</p>

* 綠界科技金流外掛套件(以下簡稱外掛套件)，提供合作特店以及個人會員使用開放原始碼商店系統時，無須自行處理複雜的檢核，直接透過安裝設定外掛套件，便可以較快速的方式介接綠界科技的金流系統。

* 收款方式清單：
	* 信用卡(一次付清、分期付款)
	* 網路ATM
	* ATM櫃員機
	* 超商代碼
	* 超商條碼


目錄
-----------------
* [支援版本](#支援版本)
* [Magento安裝準備事項](#Magento安裝準備事項)
* [套件安裝](#套件安裝)
    1. [解壓縮套件檔](#解壓縮套件檔)
    2. [更新指令](#更新指令)
* [設定與功能項目](#設定與功能項目)
    1. [設定路徑](#設定路徑)
    2. [必要參數](#必要參數)
* [注意事項](#注意事項)
* [技術支援](#技術支援)
* [參考資料](#參考資料)
* [附錄](#附錄)
	1. [測試串接參數](#測試串接參數)
	2. [curl SSL版本](#curl_SSL版本)



支援版本
-----------------
| Magento |
| :-----: |
|  2.3.3  |



Magento安裝準備事項
-----------------
無論您使用Windows、Linux或任何伺服器，在安裝本外掛套件前，請先確定該伺服器是否支援PHP的curl模組。

#### 注意事項

* 外掛套件僅支援 UTF8 語系版本的PHP商店系統。
* 如果您使用的PHP是利用AppServ軟體架設在Windows的環境，請參考以下說明將curl模組掛上：
> 1. 在WINDOWS的目錄下找到php.ini這個檔。
> 2. 使用文字編輯器(UltraEdit、EmEdit或其他)開啟php.ini檔案。
> 3. 找到extension=php_curl.dll這一行，將前面的分號移除，並儲存檔案。
> 4. 重新啟動Apache伺服器。
> 5. 若仍然無法啟動curl模組，可以按照下面步驟嘗試修正：
> 		* 在..\AppServ\php5\下找到libeay32.dll及ssleay32.dll。
> 		* 在..\AppServ\php5\ext\下找到php_curl.dll。
> 		* 將上述三個檔案複製到%windir%/system32下。
> 		* 重新啟動Apache伺服器即可。


套件安裝
-----------------
#### 解壓縮套件檔
將下載的套件檔解壓縮，完成後目錄中會有一個資料夾「app」，將此模組檔案上傳至網站目錄。若存在舊版模組，請先移除並且清除快取再上傳。

#### 更新指令
```
php bin/magento setup:upgrade
php bin/magento setup:static-content:deploy
```


設定與功能項目
-----------------

#### 設定路徑
* `購物車後台` -> `STORES` -> `Configuration` -> `SALES` -> `Payment Methods` -> `ECPay整合金流`。
* 將模組狀態改為`啟用`後即可開始使用外掛套件。

#### 必要參數
* 特店編號(Merchant ID)
* 金鑰(Hash Key)
* 向量(Hash IV)


注意事項
-----------------
* 請注意 Merchant ID、Hash Key 與 Hash IV 內容不可包含空白。
* 本外掛套件不支援後台重新建立訂單。
* 本外掛套件僅限使用台幣結帳。
* 本外掛套件提供測試模式的設定，測試模式時訂單會自動加上六碼前綴，原設定之訂單編號請勿超過十四碼。
* 本外掛套件提供測試模式的設定，用於連接到 ECPay 提供客戶的介接環境，請勿在正式營運的環境中開啟測試模式。


技術支援
-----------------
綠界技術客服信箱: techsupport@ecpay.com.tw


參考資料
-----------------
* [ECPay - 全方位金流介接技術文件](https://www.ecpay.com.tw/Content/files/ecpay_011.pdf)


附錄
-----------------

#### 測試串接參數

|  欄位名稱 | 欄位內容  |
| :------------: | :------------: |
|  特店編號(MerchantID) | 2000132 |
|  介接 HashKey |  5294y06JbISpM5x9 |
|  介接 HashIV |  v77hoKGq4kWxNNIS |

#### curl_SSL版本
* SSL Version 要為 OpenSSL