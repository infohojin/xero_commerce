<?php

namespace Xpressengine\Plugins\XeroCommerce;

use Route;
use Xpressengine\Plugin\AbstractPlugin;
use Xpressengine\Plugins\XeroCommerce\Exceptions\XeroCommercePrefixUsedException;
use Xpressengine\Plugins\XeroCommerce\Plugin\Database;
use Xpressengine\Plugins\XeroCommerce\Plugin\EventManager;
use Xpressengine\Plugins\XeroCommerce\Plugin\Resources;

class Plugin extends AbstractPlugin
{
    const XERO_COMMERCE_PREFIX = 'xero_commerce';

    const XERO_COMMERCE_URL_PREFIX = 'shopping';

    /**
     * 이 메소드는 활성화(activate) 된 플러그인이 부트될 때 항상 실행됩니다.
     *
     * @return void
     */
    public function boot()
    {
        Resources::bindClasses();
        Resources::setCanNotUseXeroCommercePrefixRoute();
        Resources::registerRoute();
        Resources::registerSettingMenu();
        EventManager::listenEvents();
    }

    /**
     * 플러그인이 활성화될 때 실행할 코드를 여기에 작성한다.
     *
     * @param string|null $installedVersion 현재 XpressEngine에 설치된 플러그인의 버전정보
     *
     * @return void
     */
    public function activate($installedVersion = null)
    {
        Resources::storeDefaultShop();
    }

    /**
     * 플러그인을 설치한다. 플러그인이 설치될 때 실행할 코드를 여기에 작성한다
     *
     * @return void
     */
    public function install()
    {
        if (Resources::isUsedXeroCommercePrefix() === true) {
            throw new XeroCommercePrefixUsedException;
        }

        Database::create();
        Resources::setConfig();
        Resources::createDefaultMainPage();
    }

    /**
     * 해당 플러그인이 설치된 상태라면 true, 설치되어있지 않다면 false를 반환한다.
     * 이 메소드를 구현하지 않았다면 기본적으로 설치된 상태(true)를 반환한다.
     *
     * @return boolean 플러그인의 설치 유무
     */
    public function checkInstalled()
    {
        return parent::checkInstalled();
    }

    /**
     * 플러그인을 업데이트한다.
     *
     * @return void
     */
    public function update()
    {

    }

    /**
     * 해당 플러그인이 최신 상태로 업데이트가 된 상태라면 true, 업데이트가 필요한 상태라면 false를 반환함.
     * 이 메소드를 구현하지 않았다면 기본적으로 최신업데이트 상태임(true)을 반환함.
     *
     * @return boolean 플러그인의 설치 유무,
     */
    public function checkUpdated()
    {
        $checkedUpdate = true;

        return $checkedUpdate;
    }
}
