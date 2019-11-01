<?php
global $MESS;
$moduleId = 'module.setting';
\Bitrix\Main\Loader::includeModule($moduleId);

IncludeModuleLangFile($_SERVER["DOCUMENT_ROOT"].BX_ROOT."/modules/main/options.php");

$loc = new \Bitrix\Main\Localization\Loc;
$loc::loadLanguageFile(__FILE__);

$MOD_RIGHT = $APPLICATION->GetGroupRight($moduleId);
if($MOD_RIGHT >= 'R'):


    $aTabs = array(
        array( // вкладка
            'DIV' => 'options', // для css
            'TAB' => 'Настройки инфоблоков', // название закладки
            'OPTIONS' => array(
                array('env',
                    'Статус среды',
                    null,
                    array('selectbox', array(
                        'DEV' => 'DEV',
                        'TEST' => 'TEST',
                        'PROD' => 'PROD',
                    )),
                ),
                array('functionBlock',
                    'Блок функций', // чтобы это ни значило
                    null,
                    array('text', 50),
                ),
            )
        ),
        array(
            'DIV' => 'log_options',
            'TAB' => 'Логирование',
            'OPTIONS' => array(
                array('log_folder',
                    'Папка с логами (указывать без первого и последнего /)',
                    null,
                    array('text', 50),
                ),
                array('process_log',
                    'Логирование API',
                    null,
                    array('selectbox', array(
                        'Y' => 'Y',
                        'N' => 'N',
                    )),
                ),
            )
        ),
        array(
            'DIV' => 'mail_options',
            'TAB' => 'Почтовые события',
            'OPTIONS' => array(
                array('send',
                    'Отправлять письма?',
                    null,
                    array('selectbox', array(
                        'Y' => 'Y',
                        'N' => 'N',
                    )),
                ),
                array('mail_log',
                    'Логировать?',
                    null,
                    array('selectbox', array(
                        'Y' => 'Y',
                        'N' => 'N',
                    )),
                ),
            )
        ),
    );

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && strlen($_REQUEST['save']) > 0 && check_bitrix_sessid())
    {
        foreach ($aTabs as $aTab)
        {
            __AdmSettingsSaveOptions($moduleId, $aTab['OPTIONS']);
        }

        LocalRedirect($APPLICATION->GetCurPage() . '?lang=' . LANGUAGE_ID . '&mid_menu=1&mid=' . urlencode($moduleId) .
            '&tabControl_active_tab=' . urlencode($_REQUEST['tabControl_active_tab']) . '&sid=' . urlencode($siteId));
    }

    ?>
    <div id="respond"></div>
    <?
    $tabControl = new CAdminTabControl('tabControl', $aTabs);
    ?>
    <form method='post' action='' name='bootstrap'>
        <? $tabControl->Begin();

        foreach ($aTabs as $aTab)
        {
            $tabControl->BeginNextTab();
            __AdmSettingsDrawList($moduleId, $aTab['OPTIONS']);
        }

        $tabControl->Buttons(array('btnApply' => false, 'btnCancel' => false, 'btnSaveAndAdd' => false)); ?>

        <?= bitrix_sessid_post(); ?>
        <? $tabControl->End(); ?>
    </form>
<? endif; ?>
<?
//echo BeginNote();
//echo "";
//echo EndNote();
?>