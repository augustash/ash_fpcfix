<?php
/**
 * Adds "theme" to Full Page Cache (FPC) exceptions allowing a different cache
 * for mobile theme.
 *
 * @category    Ash
 * @package     Ash_FpcFix
 * @copyright   Copyright (c) 2013 August Ash, Inc. (http://www.augustash.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Processor model
 *
 * @category    Ash
 * @package     Ash_FpcFix
 * @author      August Ash Team <core@augustash.com>
 */
class Ash_FpcFix_Model_Processor extends Enterprise_PageCache_Model_Processor
{
    /**
     * Populate request ids
     *
     * @return Enterprise_PageCache_Model_Processor
     */
    protected function _createRequestIds()
    {
        // call the parent function to run core code first
        parent::_createRequestIds();

        $uri = $this->_requestId;

        // Mage::log("FPC URI:" . var_export($uri, true));

        // if caching is enabled we append the theme to the URI.
        if ($uri) {
            $theme = Mage::getSingleton('core/design_package')->getTheme('frontend');
            if ($theme) {
                $uri .= '_' . $theme;
            }

            // Mage::log("FPC URI Theme:" . var_export($uri, true));

            // update the requestId and the requestCacheId.
            $this->_requestId     .= $uri;
            $this->_requestCacheId = $this->prepareCacheId($this->_requestId);
        }

        return $this;
    }
}
