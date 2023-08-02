<?php

// Import and try to configure link mobility parts
// /usr/bin/php cron.php -s site_admin -e lhclinkmobility -c cron/import
class ChatbaseActivator {

    public static function remove()
    {
        if ($restAPI = \erLhcoreClassModelGenericBotRestAPI::findOne(['filter' => ['name' => 'Chatbase']])) {
            $restAPI->removeThis();
        }

        if ($botPrevious = \erLhcoreClassModelGenericBotBot::findOne(['filter' => ['name' => 'Chatbase']])) {
            $botPrevious->removeThis();
        }
    }

    public static function installOrUpdate()
    {
        // RestAPI
        $restAPI = \erLhcoreClassModelGenericBotRestAPI::findOne(['filter' => ['name' => 'Chatbase']]);
        $content = json_decode(file_get_contents('extension/chatbase/doc/rest-api.json'),true);

        if (!$restAPI) {
            $restAPI = new \erLhcoreClassModelGenericBotRestAPI();
        }

        $restAPI->setState($content);
        $restAPI->name = 'Chatbase';
        $restAPI->saveThis();

        if ($botPrevious = \erLhcoreClassModelGenericBotBot::findOne(['filter' => ['name' => 'Chatbase']])) {
            $botPrevious->removeThis();
        }

        $botData = \erLhcoreClassGenericBotValidator::importBot(json_decode(file_get_contents('extension/chatbase/doc/bot.json'),true));
        $botData['bot']->name = 'Chatbase';
        $botData['bot']->updateThis(['update' => ['name']]);

        $trigger = $botData['triggers'][0];
        $actions = $trigger->actions_front;
        $actions[0]['content']['rest_api'] = $restAPI->id;
        $trigger->actions_front = $actions;
        $trigger->actions = json_encode($actions);
        $trigger->updateThis(['update' => ['actions']]);
    }
}

echo "Starting import\n";
ChatbaseActivator::installOrUpdate();
echo "Imported\n";