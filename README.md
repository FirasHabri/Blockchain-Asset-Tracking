
# Blockchain Asset Tracking
A supply chain consists of many different participants exchanging goods, services, and payments. It is often desirable to track the physical assets digitally to be informed about the whereabouts, to trigger processes, certify the ownership, and perform corresponding payments.

The main four functions of this supply chain managment implementation is "Create Asset" , "Transfer Asset" ,"Search Asset" and "Delete Asset". also some minor functionalities include an event history of the four main functions and a login/signup/logout pages.

## Screenshots
### View Assets
![alt text](https://github.com/FirasHabri/Blockchain-Asset-Tracking/blob/master/screenshots/index.png)

### Create Asset
![alt text](https://github.com/FirasHabri/Blockchain-Asset-Tracking/blob/master/screenshots/create.png)

### Transfer Asset
![alt text](https://github.com/FirasHabri/Blockchain-Asset-Tracking/blob/master/screenshots/transfer.png)

### Delete Asset
![alt text](https://github.com/FirasHabri/Blockchain-Asset-Tracking/blob/master/screenshots/delete.png)

### Search Asset
![alt text](https://github.com/FirasHabri/Blockchain-Asset-Tracking/blob/master/screenshots/assetDetail.png)

## Getting Started
### Prequisites
  - PHP
  - XAMPP
  - Web3JS
  - MetaMask
  - Visual Studio Code "any IDE would do the trick"
  - Google Chrome " any Browser would do the trick too"

### Run
#### Install and Setup MetaMask
go to [MetaMask](https://metamask.io/download.html) to download the extention and create an account. Switch to Rinkebey Test Network and Deposite some Ether "Go to Test Faucet and hit Get Ether". Then go to Crypto Faucet and follow the instructions.

#### XAMPP
start XAMPP Apache server and MySQL and go to http://localhost/blockchain/index.html. Don't forget to move the files to xampp/htdocs/blockchain to not get an error!.

#### Remix Ethereum
If you want to edit the .sol Contracts you need to go to [Remix Ethereum](https://remix.ethereum.org/) . switch to Solidity enviroment and create two .sol files. AssetTracker.sol and AssetLibrary.sol, Then copy the content of the contracts from this git repo into the .sol files. don't forget to compile each file first. Then in the Deploy tab switch to Injected Web3 enviroment and hit Deploy.
To use your edited contracts in the repo go to js/ether_config.js and edit the address and abi variables. you can get the address from the deploy tab and the abi from the complie tab. "Do I need to tell you everything?"

## Authors
Me

## License
Free

## Acknowledgment
Big thanks to [ ilavisharma ](https://github.com/ilavisharma/Asset-Tracker-Blockchain) for providing the base code and contracts.

