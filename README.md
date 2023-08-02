# Chatbase integration
https://www.chatbase.co/ support as a bot.

# Installation

Clone repository to extensions folder should look like

> extension > chatbase

P.s you do not need to activate this extension in `settings.ini.php` file!

There is no need to add this extension to settings file.

Run cronjob

> php cron.php -s site_admin -e chatbase -c cron/import
 
It will install all the configuration. After this step go to 

> System configuration > Live help configuration > Bot > Rest API Calls
 
* Under `Headers` tab put your token
* Under `Body` tab put your `chatbotId` id. In the bot request you can also adjust your system prompt.

# Bot configuration

Bot can be adjusted under 

> System configuration > Live help configuration > Bot > Bot constructor

Find a bot named `Chatbase` and build your own custom keywords if required.

# Department configuration

Don't forget now to set your bot in department configuration.