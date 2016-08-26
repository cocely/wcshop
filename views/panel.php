<?php

defined("BASE_PATH") OR exit("No direct script access allowed");

$session = new Session();

if(!$session->has_session("username"))
{
    header("Location: /wcshop");    
}

$username = $session->get_session("username");

$wcshop = new WCShop_model();

$account_id = $wcshop->get_account_id($username);
$dp = $wcshop->get_dp($account_id);
$characters = $wcshop->get_account_characters($account_id);
$items = $wcshop->get_items_store();

?>

<section id="panel-box">
    <article>
        <span>Hello <b><?php echo $username; ?></b>!</span>
        <span>You have <b id="dp"><?php echo $dp; ?></b> donate points.</span>
        <span><button id="logout">Logout</button></span>
    </article>
    <article>
        <span id="message"></span>
    </article>
    <table>
        <tr>
            <td>Item</td>
            <td>Price</td>
            <td>Total</td>
            <td>Amount</td>
            <td>Character</td>
            <td>Buy</td>
        </tr>
        <?php foreach($items as $item) : ?>
        <tr class="row-item">
            <td>
                <a class="wctooltip" data-item="<?php echo $item['id']; ?>"></a>
            </td>
            <td id="price">
                <?php echo $item["price"]; ?>
            </td>
            <td id="total">
                <?php echo $item["price"]; ?>
            </td>
            <td>
                <input type="number" name="amount" min="1" max="100" value="1">
            </td>
            <td>
                <select name="character">
                    <?php foreach($characters as $character) : ?>
                    <option value="<?php echo $character['name']; ?>"><?php echo $character['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
            <td>
                <input type="hidden" name="item" value="<?php echo $item['id']; ?>">
                <input type="hidden" name="price" value="<?php echo $item['price']; ?>">
                <button id="buy">Buy</button>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</section>
