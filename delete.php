<?php
session_start();
 
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>

<?php require "template/header.php" ?>

<body>
<?php require "template/navbar.php" ?>
    <h3>Deleating the asset... this may take a while..</h3>
</body>

<?php require "template/footer.php" ?>

<script>
        const web3 = new Web3(window.web3.currentProvider);

        window.addEventListener("load", async() => {
            if (window.ethereum) {
                window.web3 = new Web3(window.ethereum);
                var contract;
                $(document).ready(function() {
                    const AssetTrackerContract = new web3.eth.Contract(abi, address);

                })
                try {
                    const AssetTrackerContract = new web3.eth.Contract(abi, address);
                    await window.ethereum.enable();
                    web3.eth.getAccounts().then(function(accounts) {
                        AssetTrackerContract.methods.deleteAsset(<?php echo (int)$_GET['id'] ?>,
                                                                 <?php echo $_GET['Name'] ?>,
                                                                 <?php echo $_GET['Batch_No'] ?>).send({ from: accounts[0] }).then(result => {
                        if (result.status === true) {
                            alert("Success");
                            window.location.href = './index.php';
                        }
                    });
                    });
                        
                } catch (error) {
                    console.log(error);
                }
            }
            else if (window.web3) {
                window.web3 = new Web3(web3.currentProvider);
            }
            else {
                console.log("Non-Ethereum browser detected. You should consider trying MetaMask!");
            }
        });
    </script>