<?php

require_once realpath(dirname(__FILE__) . '/../../../..') . '/enviroment.php';

doLogin();

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.1 on 2013-07-02 at 15:31:50.
 */
class BaseWishlistTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var BaseWishlist
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->object = new wishlist\classes\BaseWishlist();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {

    }

    /**
     * @covers wishlist\classes\BaseWishlist::_install
     */
    public function test_install() {
        $this->assertNull($this->object->_install());
    }

    /**
     * @covers wishlist\classes\BaseWishlist::all
     */
    public function testAll() {
        $this->assertInternalType('array', $this->object->all());
    }

    /**
     * @covers wishlist\classes\BaseWishlist::createWishList
     */
    public function testCreateWishList() {
        $_POST['wishListName'] = 'test';
        $_POST['user_id'] = $GLOBALS['userId'];

        $this->assertSame('<p>Создано</p>', $this->object->createWishList());
    }

    /**
     * @covers wishlist\classes\BaseWishlist::addItem
     */
    public function testAddItem() {
        $this->assertSame('<p>Добавлено</p>', $this->object->addItem('1031', '1', 'test'));
        $this->object->db
                ->where('title', 'test')
                ->set('hash', '1')
                ->set('access', 'public')
                ->update('mod_wish_list');

        $this->assertInternalType('array', $this->object->addItem('1031', '1', 'teweeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeestteweeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeestteweeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeestteweeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeestteweeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeestteweeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeestteweeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeestteweeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeestteweeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeestteweeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeestteweeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeestteweeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeest'));
    }

    /**
     * @covers wishlist\classes\BaseWishlist::moveItem
     */
    public function testMoveItem() {
        $_POST['wishlist'] = 1;
        $_POST['user_id'] = $GLOBALS['userId'];
        $_POST['wishListName'] = 325;

        $this->assertEquals('<p>Операция успешна</p>', $this->object->moveItem(1031, 1));
    }

    /**
     * @covers wishlist\classes\BaseWishlist::show
     */
    public function testShow() {
        $this->assertInternalType('array', $this->object->show('1'));
    }

    /**
     * @covers wishlist\classes\BaseWishlist::getMostViewedWishLists
     */
    public function testGetMostViewedWishLists() {
        $this->assertInternalType('array', $this->object->getMostViewedWishLists());
    }

    /**
     * @covers wishlist\classes\BaseWishlist::user
     */
    public function testUser() {
        $this->assertInternalType('array', $this->object->user($GLOBALS['userId']));
    }

    /**
     * @covers wishlist\classes\BaseWishlist::getMostPopularItems
     */
    public function testGetMostPopularItems() {
        $this->assertInternalType('array', $this->object->getMostPopularItems());
    }

    /**
     * @covers wishlist\classes\BaseWishlist::userUpdate
     */
    public function testUserUpdate() {
        $_POST['description'] = 'test';
        $_POST['user_birthday'] = '1312342';
        $_POST['user_id'] = $GLOBALS['userId'];
        $_POST['user_name'] = 'sdfasdf';
        $this->assertEquals('<p>Обновлено</p>', $this->object->userUpdate());
    }

    /**
     * @covers wishlist\classes\BaseWishlist::updateWL
     */
    public function testUpdateWL() {
        $_POST['WLID'] = '1';
        $_POST['comment'] = array();
        $_POST['title'] = 1;
        $_POST['access'] = 'shared';

        $this->assertNull($this->object->updateWL());
    }

    /**
     * @covers wishlist\classes\BaseWishlist::deleteItem
     */
    public function testDeleteItem() {
        $this->assertInternalType('array', $this->object->deleteItem(2, 1));
    }

    /**
     * @covers wishlist\classes\BaseWishlist::deleteItemByIds
     */
    public function testDeleteItemByIds() {
        $_POST['listItem'] = array(1);
        $this->assertEquals('<p>Успешно удалено</p>', $this->object->deleteItemsByIds(1, 1));
    }

    /**
     * @covers wishlist\classes\BaseWishlist::renderPopup
     */
    public function testRenderPopup() {
        $this->assertInternalType('array', $this->object->renderPopup());
    }

    /**
     * @covers wishlist\classes\BaseWishlist::_deinstall
     */
    public function test_deinstall() {
        $this->assertNull($this->object->_deinstall());
    }

}
