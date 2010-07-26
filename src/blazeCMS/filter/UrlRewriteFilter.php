<?php

namespace blazeCMS\filter;

use blaze\lang\Object,
 blaze\lang\String,
 blazeCMS\WebContext,
 blazeCMS\NavigationHandler,
 blaze\io\File,
 blaze\netlet\Filter,
 blaze\netlet\NetletRequest,
 blaze\netlet\NetletResponse,
 blaze\netlet\FilterChain,
 blaze\netlet\FilterConfig;

/**
 * Description of UrlRewriteFilter
 *
 * @author  Christian Beikov
 * @license http://www.opensource.org/licenses/gpl-3.0.html GPL
 * @link    http://blazeframework.sourceforge.net
 * @see     Klassen welche nützlich für das Verständnis sein könnten oder etwas mit der aktuellen Klasse zu tun haben
 * @since   1.0
 * @version $Revision$
 * @todo    Etwas was noch erledigt werden muss
 */
class UrlRewriteFilter extends Object implements Filter {

    /**
     * Always start with '/'
     * @var blaze\lang\String
     */
    private $urlPrefix;

    public function init(FilterConfig $config) {
        $this->urlPrefix = new String('/BlazeFrameworkServer');
        $context = WebContext::getInstance();
        $context->setParameter('url.prefix', $this->urlPrefix);
    }

    public function destroy() {

    }

    public function doFilter(NetletRequest $request, NetletResponse $response, FilterChain $chain) {
        $this->buildDirectoryStructure();
        $this->buildConfig();
        $this->rewriteUrl($request);
        $chain->doFilter($request, $response);
    }

    public function buildDirectoryStructure() {
        $context = WebContext::getInstance();
        $context->setParameter('work.dir', \blaze\lang\ClassLoader::getClassPath() . '/blazeCMS');
        $context->setParameter('image.dir', $context->getParameter('work.dir') . '/image');
        $context->setParameter('style.dir', $context->getParameter('work.dir') . '/style');
        $context->setParameter('file.dir', $context->getParameter('work.dir') . '/file');
        $context->setParameter('js.dir', $context->getParameter('work.dir') . '/js');
    }

    public function buildConfig() {

    }

    public function rewriteUrl(NetletRequest $request) {
        $context = WebContext::getInstance();
        $uri = $request->getRequestURI()->getPath();

        if ($uri->startsWith($this->urlPrefix, 0, true))
            $uri = $uri->substring($this->urlPrefix->length());

        $requestPieces = $uri->trim('/')->split('/', 5, true);
        /*
         * admin - reserved for cms
         * main - is used for site action which deliver non-Html content
         */
        $context->setParameter('site', isset($requestPieces[0]) && $requestPieces[0]->length() != 0 ? $requestPieces[0] : 'home');
        /*
         *  show   -
         *  update -
         *  delete -
         *  add    -
         *  image  -
         *  file   -
         */
        $context->setParameter('site.action', isset($requestPieces[1]) && $requestPieces[0]->length() != 0 ? $requestPieces[1] : 'show');
        $context->setParameter('module', isset($requestPieces[2]) && $requestPieces[0]->length() != 0 ? $requestPieces[2] : 'index');
        $context->setParameter('module.action', isset($requestPieces[3]) && $requestPieces[0]->length() != 0 ? $requestPieces[3] : null);
        $context->setParameter('module.params', isset($requestPieces[4]) && $requestPieces[0]->length() != 0 ? $requestPieces[4] : null);
    }

}
?>
