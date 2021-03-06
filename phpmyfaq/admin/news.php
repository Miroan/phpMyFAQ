<?php
/**
 * The main administration file for the news.
 *
 * PHP Version 5.3
 *
 * This Source Code Form is subject to the terms of the Mozilla Public License,
 * v. 2.0. If a copy of the MPL was not distributed with this file, You can
 * obtain one at http://mozilla.org/MPL/2.0/.
 *
 * @category  phpMyFAQ
 * @package   Administration
 * @author    Thorsten Rinne <thorsten@phpmyfaq.de>
 * @author    Matteo Scaramuccia <matteo@phpmyfaq.de>
 * @copyright 2003-2013 phpMyFAQ Team
 * @license   http://www.mozilla.org/MPL/2.0/ Mozilla Public License Version 2.0
 * @link      http://www.phpmyfaq.de
 * @since     2003-02-23
 */

if (!defined('IS_VALID_PHPMYFAQ')) {
    header('Location: http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME']));
    exit();
}

$news = new PMF_News($faqConfig);

if ('addnews' == $action && $permission["addnews"]) {
?>
        <header>
            <h2><i class="icon-pencil"></i> <?php echo $PMF_LANG['ad_news_data']; ?></h2>
        </header>

        <form class="form-horizontal" id="faqEditor" name="faqEditor" action="?action=savenews" method="post">
        <fieldset>
            <legend><?php echo $PMF_LANG['ad_news_add']; ?></legend>

            <div class="control-group">
                <label class="control-label" for="newsheader"><?php echo $PMF_LANG['ad_news_header']; ?></label>
                <div class="controls">
                    <input class="input-xxlarge" type="text" name="newsheader">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="news"><?php echo $PMF_LANG['ad_news_text']; ?>:</label>
                <div class="controls">
                    <noscript>Please enable JavaScript to use the WYSIWYG editor!</noscript>
                    <textarea name="news" cols="84" rows="5"></textarea>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="authorName"><?php echo $PMF_LANG['ad_news_author_name']; ?></label>
                <div class="controls">
                    <input class="input-xxlarge" type="text" name="authorName" id="authorName" 
                           value="<?php echo $user->getUserData('display_name'); ?>"/>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="authorEmail"><?php echo $PMF_LANG['ad_news_author_email']; ?></label>
                <div class="controls">
                    <input class="input-xxlarge" type="email" name="authorEmail" id="authorEmail" 
                           value="<?php echo $user->getUserData('email'); ?>"/>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="active"><?php echo $PMF_LANG['ad_news_set_active']; ?></label>
                <div class="controls">
                    <label class="checkbox">
                        <input type="checkbox" name="active" id="active" value="y">
                        <?php echo $PMF_LANG['ad_gen_yes']; ?>
                    </label>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="comment"><?php echo $PMF_LANG['ad_news_allowComments']; ?></label>
                <div class="controls">
                    <label class="checkbox">
                        <input type="checkbox" name="comment" id="comment" value="y">
                        <?php echo $PMF_LANG['ad_gen_yes']; ?>
                    </label>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="link"><?php echo $PMF_LANG['ad_news_link_url']; ?></label>
                <div class="controls">
                    <input class="input-xxlarge" type="url" name="link" id="link" value="http://">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="linkTitle"><?php echo $PMF_LANG['ad_news_link_title']; ?></label>
                <div class="controls">
                    <input type="text" name="linkTitle" id="linkTitle">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" ><?php echo $PMF_LANG['ad_news_link_target']; ?></label>
                <div class="controls">
                    <label class="radio">
                        <input type="radio" name="target" value="blank">
                        <?php echo $PMF_LANG['ad_news_link_window'] ?>
                    </label>
                    <label class="radio">
                        <input type="radio" name="target" value="self">
                        <?php echo $PMF_LANG['ad_news_link_faq'] ?>
                    </label>
                    <label class="radio">
                        <input type="radio" name="target" value="parent">
                        <?php echo $PMF_LANG['ad_news_link_parent'] ?>
                    </label>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="langTo"><?php echo $PMF_LANG["ad_entry_locale"]; ?>:</label>
                <div class="controls">
                    <?php echo PMF_Language::selectLanguages($LANGCODE, false, array(), 'langTo'); ?>
                </div>
            </div>
        </fieldset>
            
        <fieldset>
            <legend><?php echo $PMF_LANG['ad_news_expiration_window']; ?></legend>
            <div class="control-group">
                <label class="control-label" for="dateStart"><?php echo $PMF_LANG['ad_news_from']; ?></label>
                <div class="controls">
                    <input type="date" name="dateStart" id="dateStart" class="date-pick">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="dateEnd"><?php echo $PMF_LANG['ad_news_to']; ?></label>
                <div class="controls">
                    <input type="date" name="dateEnd" id="dateEnd" class="date-pick">
                </div>
            </fieldset>

            <div class="form-actions">
                <button class="btn btn-primary" type="submit">
                    <?php echo $PMF_LANG['ad_news_add']; ?>
                </button>
                <a class="btn btn-info" href="?action=news">
                    <?php echo $PMF_LANG['ad_entry_back']; ?>
                </a>
            </div>
        </form>
<?php
} elseif ('news' == $action && $permission["editnews"]) {
?>
        <header>
            <h2>
                <i class="icon-pencil"></i> <?php echo $PMF_LANG["msgNews"] ?>
                <div class="pull-right">
                    <a class="btn btn-success" href="?action=addnews">
                        <i class="icon-plus icon-white"></i> <?php echo $PMF_LANG["ad_menu_news_add"] ?>
                    </a>
                </div>
            </h2>
        </header>

        <table class="table table-striped">
        <thead>
            <tr>
                <th><?php echo $PMF_LANG["ad_news_headline"]; ?></th>
                <th colspan="2"><?php echo $PMF_LANG["ad_news_date"]; ?></th>
            </tr>
        </thead>
        <tbody>
<?php
        $newsHeader = $news->getNewsHeader();
        $date       = new PMF_Date($faqConfig);
        if (count($newsHeader)) {
            foreach($newsHeader as $newsItem) {
?>
        <tr>
            <td><?php echo $newsItem['header']; ?></td>
            <td><?php echo $date->format($newsItem['date']); ?></td>
            <td>
                <a class="btn btn-primary" href="?action=editnews&amp;id=<?php echo $newsItem['id']; ?>">
                    <span title="<?php echo $PMF_LANG["ad_news_update"]; ?>" class="icon-edit"></span>
                </a>
                &nbsp;&nbsp;
                <a class="btn btn-danger" href="?action=deletenews&amp;id=<?php echo $newsItem['id']; ?>">
                    <span title="<?php echo $PMF_LANG["ad_news_delete"]; ?>" class="icon-trash"></span>
                </a>
            </td>
        </tr>
<?php
            }
        } else {
            printf(
                '<tr><td colspan="3">%s</td></tr>',
                $PMF_LANG['ad_news_nodata']
            );
        }
?>
        </tbody>
        </table>
<?php
} elseif ('editnews' == $action && $permission['editnews']) {
    $id       = PMF_Filter::filterInput(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    $newsData = $news->getNewsEntry($id, true);
?>
        <header>
            <h2><i class="icon-pencil"></i> <?php echo $PMF_LANG['ad_news_data']; ?></h2>
        </header>

        <form class="form-horizontal" action="?action=updatenews" method="post">
        <fieldset>
        <legend><?php echo $PMF_LANG['ad_news_edit']; ?></legend>

            <input type="hidden" name="id" value="<?php echo $newsData['id']; ?>">

            <div class="control-group">
                <label class="control-label" for="newsheader"><?php echo $PMF_LANG['ad_news_header']; ?></label>
                <div class="controls">
                    <input type="text" name="newsheader" id="newsheader"
                           value="<?php if (isset($newsData['header'])) { echo $newsData['header']; } ?>">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="news"><?php echo $PMF_LANG['ad_news_text']; ?>:</label>
                <div class="controls">
                    <noscript>Please enable JavaScript to use the WYSIWYG editor!</noscript>
                    <textarea id="news" name="news" cols="84" rows="5"><?php 
                        if (isset($newsData['content'])) { 
                            echo htmlspecialchars($newsData['content'], ENT_QUOTES); 
                        }
                    ?></textarea>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="authorName"><?php echo $PMF_LANG['ad_news_author_name']; ?></label>
                <div class="controls">
                    <input type="text" name="authorName" value="<?php echo $newsData['authorName']; ?>">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="authorEmail"><?php echo $PMF_LANG['ad_news_author_email']; ?></label>
                <div class="controls">
                    <input type="email" name="authorEmail" value="<?php echo $newsData['authorEmail']; ?>">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="active"><?php echo $PMF_LANG['ad_news_set_active']; ?></label>
                <div class="controls">
                    <label class="checkbox">
                        <input type="checkbox" name="active" id="active" value="y"
                            <?php if (isset($newsData['active']) && $newsData['active']) { echo " checked"; } ?>
                        <?php echo $PMF_LANG['ad_gen_yes']; ?>
                    </label>
                </div>

            </div>

            <div class="control-group">
                <label class="control-label" for="comment"><?php echo $PMF_LANG['ad_news_allowComments']; ?></label>
                <div class="controls">
                    <label class="checkbox">
                        <input type="checkbox" name="comment" id="comment" value="y"<?php if (isset($newsData['allowComments']) && $newsData['allowComments']) { echo " checked"; } ?>>
                        <?php echo $PMF_LANG['ad_gen_yes']; ?>
                    </label>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="link"><?php echo $PMF_LANG['ad_news_link_url']; ?></label>
                <div class="controls">
                    <input type="url" name="link" value="<?php echo $newsData['link']; ?>">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="linkTitle"><?php echo $PMF_LANG['ad_news_link_title']; ?></label>
                <div class="controls">
                    <input type="text" name="linkTitle" value="<?php echo $newsData['linkTitle']; ?>">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="target"><?php echo $PMF_LANG['ad_news_link_target']; ?></label>
                <div class="controls">
                    <label class="radio">
                        <input type="radio" name="target" value="blank" <?php if ('blank' == $newsData['target']) { ?>
                           checked="checked"<?php } ?>>
                        <?php echo $PMF_LANG['ad_news_link_window'] ?>
                    </label>
                    <label class="radio">
                        <input type="radio" name="target" value="self" <?php if ('self' == $newsData['target']) { ?>
                           checked="checked"<?php } ?>>
                        <?php echo $PMF_LANG['ad_news_link_faq'] ?>
                    </label>
                    <label class="radio">
                        <input type="radio" name="target" value="parent" <?php if ('parent' == $newsData['target']) { ?>
                           checked="checked"<?php } ?>>
                        <?php echo $PMF_LANG['ad_news_link_parent'] ?>
                    </label>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="langTo"><?php echo $PMF_LANG["ad_entry_locale"]; ?>:</label>
                <div class="controls">
                <?php echo PMF_Language::selectLanguages($newsData['lang'], false, array(), 'langTo'); ?>
            </div>
        </fieldset>

<?php
    $dateStart = ($newsData['dateStart'] != '00000000000000' ? PMF_Date::createIsoDate($newsData['dateStart'], 'Y-m-d') : '');
    $dateEnd   = ($newsData['dateEnd'] != '99991231235959' ? PMF_Date::createIsoDate($newsData['dateEnd'], 'Y-m-d') : '');
?>

        <fieldset>
            <legend><?php echo $PMF_LANG['ad_news_expiration_window']; ?></legend>
            <div class="control-group">
                <label class="control-label" for="dateStart"><?php echo $PMF_LANG['ad_news_from']; ?></label>
                <div class="controls">
                    <input name="dateStart" id="dateStart" class="date-pick" value="<?php echo $dateStart; ?>">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="dateEnd"><?php echo $PMF_LANG['ad_news_to']; ?></label>
                <div class="controls">
                    <input name="dateEnd" id="dateEnd" class="date-pick" value="<?php echo $dateEnd; ?>">
                </div>
            </div>
        </fieldset>

        <div class="form-actions">
            <button class="btn btn-primary" type="submit">
                <?php echo $PMF_LANG['ad_news_edit']; ?>
            </button>
            <a class="btn btn-info" href="?action=news">
                <?php echo $PMF_LANG['ad_entry_back']; ?>
            </a>
        </div>
        </form>
<?php
    $newsId   = PMF_Filter::filterInput(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    $oComment = new PMF_Comment($faqConfig);
    $comments = $oComment->getCommentsData($newsId, PMF_Comment::COMMENT_TYPE_NEWS);
    if (count($comments) > 0) {
?>
            <div class="control-group"><strong><?php echo $PMF_LANG["ad_entry_comment"] ?></strong></div>
<?php
    }
    foreach ($comments as $item) {
?>
    <div class="control-group">
        <?php echo $PMF_LANG["ad_entry_commentby"] ?>
        <a href="mailto:<?php print($item['email']); ?>">
            <?php print($item['user']); ?>
        </a>:<br>
        <?php print($item['content']); ?><br>
        <?php print($PMF_LANG['newsCommentDate'] . PMF_Date::createIsoDate($item['date'], 'Y-m-d H:i', false)); ?>
        <a href="?action=delcomment&amp;artid=<?php print($newsId); ?>&amp;cmtid=<?php print($item['id']); ?>&amp;type=<?php print(PMF_Comment::COMMENT_TYPE_NEWS);?>">
            <img src="images/delete.gif" alt="<?php echo $PMF_LANG["ad_entry_delete"] ?>" title="<?php echo $PMF_LANG["ad_entry_delete"] ?>" border="0" width="17" height="18" align="right">
        </a>
    </div>
<?php
    }
} elseif ('savenews' == $action && $permission["addnews"]) {
?>
        <header>
            <h2><i class="icon-pencil"></i> <?php echo $PMF_LANG['ad_news_data']; ?></h2>
        </header>
<?php
    $dateStart = PMF_Filter::filterInput(INPUT_POST, 'dateStart', FILTER_SANITIZE_STRING);
    $dateEnd   = PMF_Filter::filterInput(INPUT_POST, 'dateEnd', FILTER_SANITIZE_STRING);
    $header    = PMF_Filter::filterInput(INPUT_POST, 'newsheader', FILTER_SANITIZE_STRIPPED);
    $content   = PMF_Filter::filterInput(INPUT_POST, 'news', FILTER_SANITIZE_SPECIAL_CHARS);
    $author    = PMF_Filter::filterInput(INPUT_POST, 'authorName', FILTER_SANITIZE_STRIPPED);
    $email     = PMF_Filter::filterInput(INPUT_POST, 'authorEmail', FILTER_VALIDATE_EMAIL);
    $active    = PMF_Filter::filterInput(INPUT_POST, 'active', FILTER_SANITIZE_STRING);
    $comment   = PMF_Filter::filterInput(INPUT_POST, 'comment', FILTER_SANITIZE_STRING);
    $link      = PMF_Filter::filterInput(INPUT_POST, 'link', FILTER_VALIDATE_URL);
    $linktitle = PMF_Filter::filterInput(INPUT_POST, 'linkTitle', FILTER_SANITIZE_STRIPPED);
    $newslang  = PMF_Filter::filterInput(INPUT_POST, 'langTo', FILTER_SANITIZE_STRING);
    $target    = PMF_Filter::filterInput(INPUT_POST, 'target', FILTER_SANITIZE_STRIPPED);
    
    $newsData = array(
        'lang'          => $newslang,
        'header'        => $header,
        'content'       => html_entity_decode($content),
        'authorName'    => $author,
        'authorEmail'   => $email,
        'active'        => (is_null($active)) ? 'n' : 'y',
        'comment'       => (is_null($comment)) ? 'n' : 'y',
        'dateStart'     => (empty($dateStart)) ? '00000000000000' : str_replace('-', '', $dateStart) . '000000',
        'dateEnd'       => (empty($dateEnd))  ? '99991231235959' : str_replace('-', '', $dateEnd) . '235959',
        'link'          => $link,
        'linkTitle'     => $linktitle,
        'date'          => date('YmdHis'),
        'target'        => (is_null($target)) ? '' : $target
    );

    if ($news->addNewsEntry($newsData)) {
        printf('<p class="alert alert-success">%s</p>', $PMF_LANG['ad_news_updatesuc']);
    } else {
        printf('<p class="alert alert-error">%s</p>', $PMF_LANG['ad_news_insertfail']);
    }
    printf('<div class="control-group">&rarr; <a href="?action=news">%s</a></p>', $PMF_LANG['msgNews']);
} elseif ('updatenews' == $action && $permission["editnews"]) {
?>
        <header>
            <h2><i class="icon-pencil"></i> <?php echo $PMF_LANG['ad_news_data']; ?></h2>
        </header>
<?php
    $dateStart = PMF_Filter::filterInput(INPUT_POST, 'dateStart', FILTER_SANITIZE_STRING);
    $dateEnd   = PMF_Filter::filterInput(INPUT_POST, 'dateEnd', FILTER_SANITIZE_STRING);
    $header    = PMF_Filter::filterInput(INPUT_POST, 'newsheader', FILTER_SANITIZE_STRIPPED);
    $content   = PMF_Filter::filterInput(INPUT_POST, 'news', FILTER_SANITIZE_SPECIAL_CHARS);
    $author    = PMF_Filter::filterInput(INPUT_POST, 'authorName', FILTER_SANITIZE_STRIPPED);
    $email     = PMF_Filter::filterInput(INPUT_POST, 'authorEmail', FILTER_VALIDATE_EMAIL);
    $active    = PMF_Filter::filterInput(INPUT_POST, 'active', FILTER_SANITIZE_STRING);
    $comment   = PMF_Filter::filterInput(INPUT_POST, 'comment', FILTER_SANITIZE_STRING);
    $link      = PMF_Filter::filterInput(INPUT_POST, 'link', FILTER_VALIDATE_URL);
    $linktitle = PMF_Filter::filterInput(INPUT_POST, 'linkTitle', FILTER_SANITIZE_STRIPPED);
    $newslang  = PMF_Filter::filterInput(INPUT_POST, 'langTo', FILTER_SANITIZE_STRING);
    $target    = PMF_Filter::filterInput(INPUT_POST, 'target', FILTER_SANITIZE_STRIPPED);

    $newsData = array(
        'lang'        => $newslang,
        'header'      => $header,
        'content'     => html_entity_decode($content),
        'authorName'  => $author,
        'authorEmail' => $email,
        'active'      => (is_null($active)) ? 'n' : 'y',
        'comment'     => (is_null($comment)) ? 'n' : 'y',
        'dateStart'   => (empty($dateStart)) ? '00000000000000' : str_replace('-', '', $dateStart) . '000000',
        'dateEnd'     => (empty($dateEnd))   ? '99991231235959' : str_replace('-', '', $dateEnd) . '235959',
        'link'        => $link,
        'linkTitle'   => $linktitle,
        'date'        => date('YmdHis'),
        'target'      => (is_null($target)) ? '' : $target
    );
    
    $newsId = PMF_Filter::filterInput(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    if ($news->updateNewsEntry($newsId, $newsData)) {
        printf('<p class="alert alert-success">%s</p>', $PMF_LANG['ad_news_updatesuc']);
    } else {
        printf('<p class="alert alert-error">%s</p>', $PMF_LANG['ad_news_updatefail']);
    }
    printf('<div class="control-group">&rarr; <a href="?action=news">%s</a></p>', $PMF_LANG['msgNews']);
} elseif ('deletenews' == $action && $permission["delnews"]) {
?>
        <header>
            <h2><i class="icon-pencil"></i> <?php echo $PMF_LANG['ad_news_data']; ?></h2>
        </header>
<?php
    $precheck  = PMF_Filter::filterInput(INPUT_POST, 'really', FILTER_SANITIZE_STRING, 'no');
    $delete_id = PMF_Filter::filterInput(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    
    if ('no' == $precheck) {
?>
    <div class="control-group"><?php echo $PMF_LANG["ad_news_del"]; ?></div>
    <div align="center">
    <form action="?action=deletenews" method="post">
    <input type="hidden" name="id" value="<?php echo $delete_id; ?>">
    <input type="hidden" name="really" value="yes">
        <button class="btn btn-warning" type="submit" name="submit">
            <?php echo $PMF_LANG["ad_news_yesdelete"]; ?>
        </button>
        <a class="btn btn-inverse" onclick="javascript:history.back();">
            <?php echo $PMF_LANG["ad_news_nodelete"]; ?>
        </a>
    </form>
    </div>
    
    <script type="text/javascript">
    /* <![CDATA[ */
    if (!Modernizr.inputtypes.date) {
        $(function()
        {
            $('.date-pick').datePicker();
        });
    }
    /* ]]> */
    </script>
<?php
    } else {
        $delete_id = PMF_Filter::filterInput(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $news->deleteNews($delete_id);
        printf('<p class="alert alert-success">%s</p>', $PMF_LANG['ad_news_delsuc']);
        printf('<div class="control-group">&rarr; <a href="?action=news">%s</a></p>', $PMF_LANG['msgNews']);
    }
} else {
    echo $PMF_LANG["err_NotAuth"];
}
