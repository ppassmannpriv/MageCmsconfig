<?php

class Scriptkid_Cmsconfig_Helper_Wysiwyg_Images extends Mage_Cms_Helper_Wysiwyg_Images
{
  /**
   * Prepare Image insertion declaration for Wysiwyg or textarea(as_is mode)
   *
   * @param string $filename Filename transferred via Ajax
   * @param bool $renderAsTag Leave image HTML as is or transform it to controller directive
   * @return string
   */
  public function getImageHtmlDeclaration($filename, $renderAsTag = false)
  {
      $fileurl = $this->getCurrentUrl() . $filename;
      $mediaPath = str_replace(Mage::getBaseUrl('media'), '', $fileurl);
      $directive = sprintf('{{media url="%s"}}', $mediaPath);
      $fileExtension = end(explode('.', $filename));

      if ($renderAsTag) {
        if($fileExtension == 'pdf')
        {
          $html = sprintf('<a href="%s" title="">'.$filename.'</a>', $this->isUsingStaticUrlsAllowed() ? $fileurl : $directive);
        } else {
          $html = sprintf('<img class="test" src="%s" alt="" />', $this->isUsingStaticUrlsAllowed() ? $fileurl : $directive);
        }
      } else {
          if ($this->isUsingStaticUrlsAllowed()) {
              $html = $fileurl; // $mediaPath;
          } else {
              $directive = Mage::helper('core')->urlEncode($directive);
              $html = Mage::helper('adminhtml')->getUrl('*/cms_wysiwyg/directive', array('___directive' => $directive));
          }
      }

      return $html;
  }
}
