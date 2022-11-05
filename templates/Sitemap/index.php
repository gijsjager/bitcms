<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <?php foreach ($sitemap as $item){ ?>
        <url>
            <loc><?php echo $this->Url->build(['controller' => $item->controller, 'action' => 'view', $item->slug, 'lang' => $this->request->getParam('lang')], TRUE); ?></loc>
            <lastmod><?php echo $this->Time->toAtom(new \Cake\I18n\Time()); ?></lastmod>
            <changefreq>weekly</changefreq>
        </url>
    <?php } // endforeach ?>
</urlset>