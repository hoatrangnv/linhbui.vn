<?php

use frontend\models\Menu;

?>
<?php
if (!$this->context->is_mobile) {
?>
<div class="menu side-menu fluid">
    <ul>
        <li class="title">
            <a href="javascript:;" title="Menu">
                <i class="menu-button"></i>
                &nbsp;
                <span>Menu</span>
            </a>
        </li>
    <?php
    foreach (Menu::getTopParents() as $item) {
        $children = $item->getChildren();
    ?><li class="<?= $item->isCurrent() ? 'active' : '' ?> <?= $children !== [] ? 'multi-level' : '' ?>">
            <?= $item->a() ?>
            <?php
            if ($children !== []) {
            ?>
            <button type="button"><?= $item->isCurrent() ? '<i class="down-orange-arrow"></i>' : '<i class="right-orange-arrow"></i>' ?></button>
            <ul class="<?= $item->isCurrent() ? 'open' : '' ?>">
                <?php
                foreach ($children as $c) {
                    ?><li class="<?= $c->isCurrent() ? 'active' : '' ?>">
                    <?= $c->a() ?>
                    <?php
                    if (($children2 = $c->getChildren()) !== []) {
                    ?>
                    <button type="button"><?= $c->isCurrent() ? '<i class="down-orange-arrow"></i>' : '<i class="right-orange-arrow"></i>' ?></button>
                    <ul class="<?= $c->isCurrent() ? 'open' : '' ?>">
                        <?php
                        foreach ($children2 as $c2) {
                        ?><li class="<?= $c2->isCurrent() ? 'active' : '' ?>">
                            <?= $c2->a() ?>
                        </li><?php
                        }
                        ?>
                    </ul>
                    <?php
                    }
                    ?>
                </li><?php
                }
                ?>
            </ul>
            <?php
            }
            ?>
        </li><?php
    }
    ?>
    </ul>
</div>
<style>
.side-menu {
    margin-top: 0;
}
.side-menu li > button {
    text-align: center;
    color: #cea00e;
    background: none;
    position: absolute;
    border: none;
    width: 3.2em;
    line-height: calc(3.2em - 1px);
    height: 3.2em;
    top: 0;
    right: 0;
}
.side-menu li.active > a {
    font-weight: bold;
}
.side-menu li > ul {
    overflow: hidden;
    height: 0;
}
.side-menu li.active > ul {
    height: auto;
}
.side-menu > ul > li > ul > li > ul {
    text-transform: none;
    color: #939393;
}
.side-menu > ul > li ul > li {
    padding-left: 0.5em;
}
.side-menu .title {
    color: #fff;
    font-weight: bold;
    border-top-width: 1px;
    background: #d9ae5e;
    border-color: #d9ae5e;
}
.side-menu .title svg {
    width: 2em;
    height: 2em;
    display: inline-block;
    vertical-align: middle;
    margin-right: 0.5em;
    margin-top: -0.3em
}
.side-menu li a {
    width: 100%;
    padding: 0.75em;
    display: inline-block;
}
.side-menu li a:hover {
    text-decoration: underline;
}
.side-menu li.title a:hover {
    text-decoration: none;
    cursor: default;
}
.side-menu > ul > li {
    border: 1px solid #fdebc4;
    border-top-width: 0;
    color: #cea00e;
    text-transform: uppercase;
}
.side-menu li.multi-level {
    border-left: 3px solid #d9ae5e;
    padding-left: 2px;
}
@media screen and (max-width: 740px) {
    .side-menu {
        display: none;
    }
}
</style>
<?php
}
