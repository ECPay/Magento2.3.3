Magento2.3 綠界科技金流模組
===============
<p align="center">
    <img alt="Last Release" src="https://img.shields.io/github/release/ECPay/Magento2.3.3.svg">
</p>

* 綠界科技金流模組，提供合作特店以及個人會員使用開放原始碼商店系統時，無須自行處理複雜的檢核，直接透過安裝設定模組，便可以較快速的方式介接綠界科技的金流系統。

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
* [綠界模組安裝流程](#綠界模組安裝流程)
    1. [解壓縮安裝檔](#解壓縮安裝檔)
    2. [模組目錄放置規則](#模組目錄放置規則)
    3. [更新指令](#更新指令)
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
無論您使用 Windows、Linux 或任何伺服器，在安裝本模組前，請先確定該伺服器是否支援 PHP 的 curl 模組。

#### 注意事項

* 綠界金流模組僅支援 UTF8 語系版本的PHP商店系統。
* 請務必確認使用的 PHP 目錄是否加到環境變數 path。
* 如果您使用的 PHP 是利用 AppServ 軟體架設在 Windows 的環境，請參考以下說明將 curl 模組掛上：
> 1. 在 WINDOWS 的目錄下找到 php.ini 這個檔。
> 2. 使用文字編輯器(UltraEdit、EmEdit 或其他)開啟 php.ini 檔案。
> 3. 找到 extension=php_curl.dll 這一行，將前面的分號移除，並儲存檔案。
> 4. 重新啟動 Apache 伺服器。
> 5. 若仍然無法啟動 curl 模組，可以按照下面步驟嘗試修正：
> 		* 在 ..\AppServ\php5\ 下找到 libeay32.dll 及ssleay32.dll。
> 		* 在 ..\AppServ\php5\ext\ 下找到 php_curl.dll。
> 		* 將上述三個檔案複製到 %windir%/system32 下。
> 		* 重新啟動 Apache 伺服器即可。


綠界模組安裝流程
-----------------
#### 解壓縮安裝檔
將下載的檔案解壓縮，完成後請參照下方[模組目錄放置規則](#模組目錄放置規則)，把綠界模組放置對應的網站目錄下，再執行[更新指令](#更新指令)。

※ 提醒：<br>
1. 若存在舊版模組，請先移除並且清除快取再上傳。<br>
2. 做完任何設定調整，都需清除快取，才能使用調整後的設定，以下為清除快取的購物車網站路徑：
```
購物車後台 ＞ SYSTEM ＞ Cache Management ＞ Flush Magento Cache
```

#### 模組目錄放置規則
1. 若您的 Magento 購物車內已存在 code 資料夾，請複製 code 內的 Ecpay 資料夾到 Magento 購物車內的 code 資料夾。
2. 若您的 Magento 購物車內不存在 code 資料夾，請複製 code 資料夾到 Magento 購物車的 app 資料夾。

#### 更新指令
請按順序執行以下指令，並在每一步驟完成後，至購物車進行確認是否有出現綠界付款方式`(購物車後台 ＞ STORES ＞ Configuration ＞ Sales ＞ Payment Methods)`，若有出現請不需再執行下一步。
```
php bin/magento setup:upgrade

php bin/magento setup:di:compile

php bin/magento setup:static-content:deploy -f
```


設定與功能項目
-----------------

#### 設定路徑
* `購物車後台` ＞ `STORES` ＞ `Configuration` ＞ `SALES` ＞ `Payment Methods` ＞ `ECPay整合金流`。
* 將模組狀態改為`啟用`後即可開始使用。

#### 必要參數
* 特店編號(Merchant ID)
* 金鑰(Hash Key)
* 向量(Hash IV)


注意事項
-----------------
* 請注意 `Merchant ID`、`Hash Key` 與 `Hash IV` 內容不可包含空白。
* 本模組不支援後台重新建立訂單。
* 本模組僅限使用`台幣`結帳。
* 本模組提供測試模式的設定，測試模式時訂單會自動加上 6 碼前綴，原設定之訂單編號請勿超過 14 碼。
* 本模組提供測試模式的設定，用於連接到 ECPay 提供客戶的介接環境，請勿在正式營運的環境中開啟測試模式。


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