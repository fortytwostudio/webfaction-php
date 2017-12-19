<?php

namespace FortyTwoStudio\WebFactionPHP;

/**
 * WebFactionClient
 * PHP wrapper for the WebFaction XML-RPC API
 * https://docs.webfaction.com/xmlrpc-api/
 */

use PhpXmlRpc\Request;
use PhpXmlRpc\Client;
use PhpXmlRpc\Encoder;

class WebFactionClient
{
    private $client;
    private $encoder;
    private $sessionId = null;
    private $version;


    /**
     * WebFactionClient constructor.
     *
     * @param string $username
     * @param string $password
     * @param null   $machine
     * @param int    $version optional, defaults to version 1, see https://docs.webfaction.com/xmlrpc-api/apiref.html#general
     */
    public function __construct($username, $password, $machine = null, $version = 1)
    {
        $this->client    = new Client('https://api.webfaction.com/');
        $this->encoder   = new Encoder();
        $this->version   = $version;
        $this->sessionId = $this->send('login', $username, $password, $machine, $version)[0];
    }


    /****************************************************************
     * General                                                      *
     * https://docs.webfaction.com/xmlrpc-api/apiref.html#general   *
     ***************************************************************/

    /**
     * https://docs.webfaction.com/xmlrpc-api/apiref.html#method-list_disk_usage
     * @return mixed
     */
    public function listDiskUsage()
    {
        return $this->send('list_disk_usage');
    }


    /****************************************************************
     * Email - mailboxes                                            *
     * https://docs.webfaction.com/xmlrpc-api/apiref.html#mailboxes *
     ***************************************************************/

    /**
     * https://docs.webfaction.com/xmlrpc-api/apiref.html#method-list_mailboxes
     * @return mixed
     */
    public function listMailboxes()
    {
        return $this->send('list_mailboxes');
    }

    /**
     * https://docs.webfaction.com/xmlrpc-api/apiref.html#method-create_mailbox
     * @param string $name
     * @param bool   $enableSpamPrevention
     * @param bool   $discardSpam
     * @param string $spamRedirectFolder
     * @param bool   $useManualProcmailrc
     * @param string $manualProcmailrc
     * @return mixed
     */
    public function createMailbox($name, $enableSpamPrevention = true, $discardSpam = false, $spamRedirectFolder = '', $useManualProcmailrc = false, $manualProcmailrc = '')
    {
        return $this->send('create_mailbox', $name, $enableSpamPrevention, $discardSpam, $spamRedirectFolder, $useManualProcmailrc, $manualProcmailrc);
    }

    /**
     * https://docs.webfaction.com/xmlrpc-api/apiref.html#method-update_mailbox
     * @param string $name
     * @param bool   $enableSpamPrevention
     * @param bool   $discardSpam
     * @param string $spamRedirectFolder
     * @param bool   $useManualProcmailrc
     * @param string $manualProcmailrc
     * @return mixed
     */
    public function updateMailbox($name, $enableSpamPrevention = true, $discardSpam = false, $spamRedirectFolder = '', $useManualProcmailrc = false, $manualProcmailrc = '')
    {
        return $this->send('update_mailbox', $name, $enableSpamPrevention, $discardSpam, $spamRedirectFolder, $useManualProcmailrc, $manualProcmailrc);
    }

    /**
     * https://docs.webfaction.com/xmlrpc-api/apiref.html#method-change_mailbox_password
     * @param string $mailbox
     * @param string $password
     * @return mixed
     */
    public function changeMailboxPassword($mailbox, $password)
    {
        return $this->send('change_mailbox_password', $mailbox, $password);
    }

    /**
     * https://docs.webfaction.com/xmlrpc-api/apiref.html#method-delete_mailbox
     * @param string $name
     * @return mixed
     */
    public function deleteMailbox($name)
    {
        return $this->send('delete_mailbox', $name);
    }


    /****************************************************************
     * Email - addresses                                            *
     * https://docs.webfaction.com/xmlrpc-api/apiref.html#addresses *
     ***************************************************************/

    /**
     * https://docs.webfaction.com/xmlrpc-api/apiref.html#method-create_email
     * @param string $address
     * @param string $targets
     * @param bool   $autoresponderOn
     * @param string $autoresponderSubject
     * @param string $autoresponderMessage
     * @param string $autoresponderFrom
     * @param string $scriptMachine
     * @param string $scriptPath
     * @return mixed
     */
    public function createEmail($address, $targets, $autoresponderOn = false, $autoresponderSubject = '', $autoresponderMessage = '', $autoresponderFrom = '', $scriptMachine = '', $scriptPath = '')
    {
        return $this->send('create_email', $address, $targets, $autoresponderOn, $autoresponderSubject, $autoresponderMessage, $autoresponderFrom, $scriptMachine, $scriptPath);
    }

    /**
     * https://docs.webfaction.com/xmlrpc-api/apiref.html#method-delete_email
     * @param string $address
     * @return mixed
     */
    public function deleteEmail($address)
    {
        return $this->send('delete_email', $address);
    }

    /**
     * https://docs.webfaction.com/xmlrpc-api/apiref.html#method-list_emails
     * @return mixed
     */
    public function listEmails()
    {
        return $this->send('list_emails');
    }

    /**
     * https://docs.webfaction.com/xmlrpc-api/apiref.html#method-update_email
     * @param string $address
     * @param string $targets
     * @param bool   $autoresponderOn
     * @param string $autoresponderSubject
     * @param string $autoresponderMessage
     * @param string $autoresponderFrom
     * @param string $scriptMachine
     * @param string $scriptPath
     */
    public function updateEmail($address, $targets, $autoresponderOn = false, $autoresponderSubject = '', $autoresponderMessage = '', $autoresponderFrom = '', $scriptMachine = '', $scriptPath = '')
    {
        $this->send('update_email', $address, $targets, $autoresponderOn, $autoresponderSubject, $autoresponderMessage, $autoresponderFrom, $scriptMachine, $scriptPath);
    }


    /****************************************************************************************
     * Websites, Domains and Certificates                                                   *
     * https://docs.webfaction.com/xmlrpc-api/apiref.html#websites-domains-and-certificates *
     ***************************************************************************************/

    /**
     * https://docs.webfaction.com/xmlrpc-api/apiref.html#method-list_certificates
     * @return mixed
     * @throws WebFactionException
     */
    public function listCertificates()
    {
        $this->notAvailableInVersions(1);

        return $this->send('list_certificates');
    }

    /**
     * https://docs.webfaction.com/xmlrpc-api/apiref.html#method-create_certificate
     * @param string $name
     * @param string $certificate
     * @param string $privateKey
     * @param string $intermediates
     * @return mixed
     * @throws WebFactionException
     */
    public function createCertificate($name, $certificate, $privateKey, $intermediates)
    {
        $this->notAvailableInVersions(1);

        return $this->send('create_certificate', $name, $certificate, $privateKey, $intermediates);
    }

    /**
     * https://docs.webfaction.com/xmlrpc-api/apiref.html#method-update_certificate
     * @param $name
     * @param $certificate
     * @param $privateKey
     * @param $intermediates
     * @return mixed
     * @throws WebFactionException
     */
    public function updateCertificate($name, $certificate, $privateKey, $intermediates)
    {
        $this->notAvailableInVersions(1);

        return $this->send('update_certificate', $name, $certificate, $privateKey, $intermediates);
    }

    /**
     * https://docs.webfaction.com/xmlrpc-api/apiref.html#method-delete_certificate
     * @param $name
     * @return mixed
     * @throws WebFactionException
     */
    public function deleteCertificate($name)
    {
        $this->notAvailableInVersions(1);

        return $this->send('delete_certificate', $name);
    }


    /**
     * https://docs.webfaction.com/xmlrpc-api/apiref.html#method-list_domains
     * @return mixed
     */
    public function listDomains()
    {
        return $this->send('list_domains');
    }

    /**
     * https://docs.webfaction.com/xmlrpc-api/apiref.html#method-create_domain
     * @param string $name
     * @param array  $subdomains
     * @return mixed
     */
    public function createDomain($name, array $subdomains = [])
    {
        return $this->send('create_domain', strtolower($name), ...$subdomains);
    }

    /**
     * https://docs.webfaction.com/xmlrpc-api/apiref.html#method-delete_domain
     * @param string $name
     * @param array  $subdomains
     * @return mixed
     */
    public function deleteDomain($name, array $subdomains = [])
    {
        return $this->send('delete_domain', strtolower($name), ...$subdomains);
    }

    /**
     * https://docs.webfaction.com/xmlrpc-api/apiref.html#method-list_bandwidth_usage
     * @return mixed
     */
    public function listBandwidthUsage()
    {
        return $this->send('list_bandwidth_usage');
    }

    /**
     * https://docs.webfaction.com/xmlrpc-api/apiref.html#method-list_websites
     * @return mixed
     */
    public function listWebsites()
    {
        return $this->send('list_websites');
    }


    /**
     * https://docs.webfaction.com/xmlrpc-api/apiref.html#method-create_website
     * @param array ...$params
     * @return mixed
     * @throws WebFactionException
     */
    public function createWebsite(...$params)
    {
        $name      = array_shift($params);
        $ipAddress = array_shift($params);
        $https     = array_shift($params);
        $domains   = array_shift($params);

        if ($this->version === 1)
        {
            $siteApps = $params;

            return $this->createV1Website($name, $ipAddress, $https, $domains, ...$siteApps);
        }

        $certificate = array_shift($params);
        $siteApps    = $params;

        return $this->createV2Website($name, $ipAddress, $https, $domains, $certificate, ...$siteApps);

    }

    /**
     * https://docs.webfaction.com/xmlrpc-api/apiref.html#method-create_website
     * @param string  $name
     * @param string  $ipAddress
     * @param bool    $https
     * @param array   $domains
     * @param array[] $siteApps
     * @return mixed
     */
    private function createV1Website($name, $ipAddress, $https, array $domains, array...$siteApps)
    {

        return $this->send('create_website', $name, $ipAddress, $https, $domains, ...$siteApps);
    }

    /**
     * https://docs.webfaction.com/xmlrpc-api/apiref.html#method-create_website
     * @param         $name
     * @param         $ipAddress
     * @param         $https
     * @param array   $domains
     * @param string  $certificate
     * @param array[] ...$siteApps
     * @return mixed
     */
    private function createV2Website($name, $ipAddress, $https, array $domains, $certificate = '', array...$siteApps)
    {
        return $this->send('create_website', $name, $ipAddress, $https, $domains, $certificate, ...$siteApps);
    }

    /**
     * https://docs.webfaction.com/xmlrpc-api/apiref.html#method-update_website
     * @param array ...$params
     * @return mixed
     * @throws WebFactionException
     */
    public function updateWebsite(...$params)
    {
        $name      = array_shift($params);
        $ipAddress = array_shift($params);
        $https     = array_shift($params);
        $domains   = array_shift($params);

        if ($this->version === 1)
        {
            $siteApps = $params;

            return $this->updateV1Website($name, $ipAddress, $https, $domains, $siteApps);
        }

        $certificate = array_shift($params);
        $siteApps    = $params;

        return $this->updateV2Website($name, $ipAddress, $https, $domains, $certificate, $siteApps);
    }

    /**
     * https://docs.webfaction.com/xmlrpc-api/apiref.html#method-update_website
     * @param string $name
     * @param string $ipAddress
     * @param bool   $https
     * @param array  $domains
     * @param array  $siteApps
     * @return mixed
     */
    public function updateV1Website($name, $ipAddress, $https, array $domains, array $siteApps)
    {
        return $this->send('update_website', $name, $ipAddress, $https, $domains, ...$siteApps);
    }

    /**
     * https://docs.webfaction.com/xmlrpc-api/apiref.html#method-update_website
     * @param string $name
     * @param string $ipAddress
     * @param bool   $https
     * @param array  $domains
     * @param string $certificate
     * @param array  $siteApps
     * @return mixed
     */
    public function updateV2Website($name, $ipAddress, $https, array $domains, $certificate = '', array $siteApps)
    {
        return $this->send('update_website', $name, $ipAddress, $https, $domains, $certificate, ...$siteApps);
    }

    /**
     * https://docs.webfaction.com/xmlrpc-api/apiref.html#method-delete_website
     * @param string $name
     * @param string $ipAddress
     * @param bool   $https
     * @return mixed
     */
    public function deleteWebsite($name, $ipAddress, $https = false)
    {
        return $this->send('delete_website', $name, $ipAddress, $https);
    }


    /********************************************************************
     * Applications                                                     *
     * https://docs.webfaction.com/xmlrpc-api/apiref.html#applications  *
     *******************************************************************/

    /**
     * https://docs.webfaction.com/xmlrpc-api/apiref.html#method-list_app_types
     * @return mixed
     */
    public function listAppTypes()
    {
        return $this->send('list_app_types');
    }

    /**
     * https://docs.webfaction.com/xmlrpc-api/apiref.html#method-list_apps
     * @return mixed
     */
    public function listApps()
    {
        return $this->send('list_apps');
    }

    /**
     * https://docs.webfaction.com/xmlrpc-api/apiref.html#method-create_app
     * @param string $name
     * @param string $type
     * @param bool   $autostart
     * @param string $extraInfo
     * @param bool   $openPort
     * @return mixed
     */
    public function createApp($name, $type, $autostart = false, $extraInfo = '', $openPort = false)
    {
        return $this->send('create_app', $name, $type, $autostart, $extraInfo, $openPort);
    }

    /**
     * https://docs.webfaction.com/xmlrpc-api/apiref.html#method-delete_app
     * @param string $name
     * @return mixed
     */
    public function deleteApp($name)
    {
        return $this->send('delete_app', $name);
    }


    /************************************************************
     * Cron                                                     *
     * https://docs.webfaction.com/xmlrpc-api/apiref.html#cron  *
     ***********************************************************/

    /**
     * https://docs.webfaction.com/xmlrpc-api/apiref.html#method-create_cronjob
     * @param string $line
     * @return mixed
     */
    public function createCronJob($line)
    {
        return $this->send('create_cronjob', $line);
    }

    /**
     * https://docs.webfaction.com/xmlrpc-api/apiref.html#method-delete_cronjob
     * @param string $line
     * @return mixed
     */
    public function deleteCronJob($line)
    {
        return $this->send('delete_cronjob', $line);
    }


    /***********************************************************
     * DNS                                                     *
     * https://docs.webfaction.com/xmlrpc-api/apiref.html#dns  *
     **********************************************************/

    /**
     * https://docs.webfaction.com/xmlrpc-api/apiref.html#method-list_dns_overrides
     * @return mixed
     */
    public function listDnsOverrides()
    {
        return $this->send('list_dns_overrides');
    }

    /**
     * https://docs.webfaction.com/xmlrpc-api/apiref.html#method-create_dns_override
     * @param string $domain
     * @param string $ARecord
     * @param string $CNAME
     * @param string $MXName
     * @param string $MXPriority
     * @param string $SPFRecord
     * @param string $IPV6Address
     * @param string $SRVRecord
     * @return mixed
     */
    public function createDnsOverride($domain, $ARecord = '', $CNAME = '', $MXName = '', $MXPriority = '', $SPFRecord = '', $IPV6Address = '', $SRVRecord = '')
    {
        return $this->send('create_dns_override', $domain, $ARecord, $CNAME, $MXName, $MXPriority, $SPFRecord, $IPV6Address, $SRVRecord);
    }

    /**
     * https://docs.webfaction.com/xmlrpc-api/apiref.html#method-delete_dns_override
     * @param string $domain
     * @param string $ARecord
     * @param string $CNAME
     * @param string $MXName
     * @param string $MXPriority
     * @param string $SPFRecord
     * @param string $IPV6Address
     * @param string $SRVRecord
     * @return mixed
     */
    public function deleteDnsOverride($domain, $ARecord = '', $CNAME = '', $MXName = '', $MXPriority = '', $SPFRecord = '', $IPV6Address = '', $SRVRecord = '')
    {
        return $this->send('delete_dns_override', $domain, $ARecord, $CNAME, $MXName, $MXPriority, $SPFRecord, $IPV6Address, $SRVRecord);
    }


    /****************************************************************
     * Databases                                                    *
     * https://docs.webfaction.com/xmlrpc-api/apiref.html#databases *
     ***************************************************************/

    /**
     * https://docs.webfaction.com/xmlrpc-api/apiref.html#method-list_dbs
     * @return mixed
     */
    public function listDbs()
    {
        return $this->send('list_dbs');
    }

    /**
     * https://docs.webfaction.com/xmlrpc-api/apiref.html#method-create_db
     * @param string $name
     * @param string $dbType
     * @param string $password
     * @param string $dbUser
     * @return mixed
     */
    public function createDb($name, $dbType, $password, $dbUser = '')
    {
        $password = ($dbUser !== '') ? '' : $password;

        return $this->send('create_db', $name, $dbType, $password, $dbUser);
    }

    /**
     * https://docs.webfaction.com/xmlrpc-api/apiref.html#method-enable_addon
     * @param string $dbName
     * @param string $dbType
     * @param string $addon
     * @return mixed
     */
    public function enableAddon($dbName, $dbType, $addon)
    {
        return $this->send('enable_addon', $dbName, $dbType, $addon);
    }

    /**
     * https://docs.webfaction.com/xmlrpc-api/apiref.html#method-delete_db
     * @param string $dbName
     * @param string $dbType
     * @return mixed
     */
    public function deleteDb($dbName, $dbType)
    {
        return $this->send('delete_db', $dbName, $dbType);
    }

    /**
     * https://docs.webfaction.com/xmlrpc-api/apiref.html#method-list_db_users
     * @return mixed
     */
    public function listDbUsers()
    {
        return $this->send('list_db_users');
    }

    /**
     * https://docs.webfaction.com/xmlrpc-api/apiref.html#method-create_db_user
     * @param string $username
     * @param string $password
     * @param string $dbType
     * @return mixed
     */
    public function createDbUser($username, $password, $dbType)
    {
        return $this->send('create_db_user', $username, $password, $dbType);
    }

    /**
     * https://docs.webfaction.com/xmlrpc-api/apiref.html#method-change_db_user_password
     * @param string $username
     * @param string $password
     * @param string $dbType
     * @return mixed
     */
    public function changeDbUserPassword($username, $password, $dbType)
    {
        return $this->send('change_db_user_password', $username, $password, $dbType);
    }

    /**
     * https://docs.webfaction.com/xmlrpc-api/apiref.html#method-grant_db_permissions
     * @param string $username
     * @param string $dbName
     * @param string $dbType
     * @return mixed
     */
    public function grantDbPermissions($username, $dbName, $dbType)
    {
        return $this->send('grant_db_permissions', $username, $dbName, $dbType);
    }

    /**
     * https://docs.webfaction.com/xmlrpc-api/apiref.html#method-make_user_owner_of_db
     * @param string $username
     * @param string $dbName
     * @param string $dbType
     * @return mixed
     */
    public function makeUserOwnerOfDb($username, $dbName, $dbType)
    {
        return $this->send('make_user_owner_of_db', $username, $dbName, $dbType);
    }

    /**
     * https://docs.webfaction.com/xmlrpc-api/apiref.html#method-revoke_db_permissions
     * @param string $username
     * @param string $dbName
     * @param string $dbType
     * @return mixed
     */
    public function revokeDbPermissions($username, $dbName, $dbType)
    {
        return $this->send('revoke_db_permissions', $username, $dbName, $dbType);
    }

    /**
     * https://docs.webfaction.com/xmlrpc-api/apiref.html#method-delete_db_user
     * @param string $username
     * @param string $dbType
     * @return mixed
     */
    public function deleteDbUser($username, $dbType)
    {
        return $this->send('delete_db_user', $username, $dbType);
    }


    /************************************************************
     * Files                                                    *
     * https://docs.webfaction.com/xmlrpc-api/apiref.html#files *
     ***********************************************************/

    /**
     * https://docs.webfaction.com/xmlrpc-api/apiref.html#method-write_file
     * @param string $filename
     * @param string $string
     * @param string $mode
     * @return mixed
     */
    public function writeFile($filename, $string, $mode = "wb")
    {
        return $this->send('write_file', $filename, $string, $mode);
    }

    /**
     * https://docs.webfaction.com/xmlrpc-api/apiref.html#method-replace_in_file
     * @param string   $filename
     * @param \array[] ...$changes
     * @return mixed
     */
    public function replaceInFile($filename, array ...$changes)
    {
        return $this->send('replace_in_file', $filename, $changes);
    }


    /********************************************************************
     * Shell Users                                                      *
     * https://docs.webfaction.com/xmlrpc-api/apiref.html#shell-users   *
     *******************************************************************/

    /**
     * https://docs.webfaction.com/xmlrpc-api/apiref.html#method-list_users
     * @return mixed
     */
    public function listUsers()
    {
        return $this->send('list_users');
    }

    /**
     * https://docs.webfaction.com/xmlrpc-api/apiref.html#method-create_user
     * @param string $username
     * @param string $shell
     * @param array  $groups
     * @return mixed
     */
    public function createUser($username, $shell, array $groups = [])
    {
        return $this->send('create_user', $username, $shell, $groups);
    }

    /**
     * https://docs.webfaction.com/xmlrpc-api/apiref.html#method-change_user_password
     * @param string $username
     * @param string $password
     * @return mixed
     */
    public function changeUserPassword($username, $password)
    {
        return $this->send('change_user_password', $username, $password);
    }

    /**
     * https://docs.webfaction.com/xmlrpc-api/apiref.html#method-delete_user
     * @param string $username
     * @return mixed
     */
    public function deleteUser($username)
    {
        return $this->send('delete_user', $username);
    }


    /****************************************************************
     * Servers                                                      *
     * https://docs.webfaction.com/xmlrpc-api/apiref.html#servers   *
     ***************************************************************/

    /**
     * https://docs.webfaction.com/xmlrpc-api/apiref.html#method-list_ips
     * @return mixed
     */
    public function listIps()
    {
        return $this->send('list_ips');
    }

    /**
     * https://docs.webfaction.com/xmlrpc-api/apiref.html#method-list_machines
     * @return mixed
     */
    public function listMachines()
    {
        return $this->send('list_machines');
    }


    /********************************************************************
     * Miscellaneous                                                    *
     * https://docs.webfaction.com/xmlrpc-api/apiref.html#miscellaneous *
     *******************************************************************/

    /**
     * https://docs.webfaction.com/xmlrpc-api/apiref.html#method-run_php_script
     * @param string $scriptPath
     * @param string $codeBefore
     * @return mixed
     */
    public function runPhpScript($scriptPath, $codeBefore)
    {
        return $this->send('run_php_script', $scriptPath, $codeBefore);
    }

    /**
     * https://docs.webfaction.com/xmlrpc-api/apiref.html#method-set_apache_acl
     * @param string|string[] $path
     * @param string          $permissions
     * @param bool            $recursive
     * @return mixed
     */
    public function setApacheAcl($path, $permissions, $recursive = false)
    {
        return $this->send('set_apache_acl', $path, $permissions, $recursive);
    }

    /**
     * https://docs.webfaction.com/xmlrpc-api/apiref.html#method-system
     * @param string $command
     * @return mixed
     */
    public function system($command)
    {
        return $this->send('system', $command);
    }

    /****************************************************************/
    /****************************************************************/
    /*********************** HELPER FUNCTIONS ***********************/
    /****************************************************************/
    /****************************************************************/

    /**
     * @param       $endpoint
     * @param array ...$options
     * @return mixed
     * @throws WebFactionException
     */
    private function send($endpoint, ...$options)
    {
        if ($endpoint !== 'login' && is_null($this->sessionId))
        {
            throw new WebFactionException("You are not logged in", 403);
        }

        $params = [];
        if ($endpoint !== 'login')
        {
            //the session ID is always the first parameter in the call
            $params[] = $this->encoder->encode($this->sessionId);
        }
        foreach ($options as $param)
        {
            $params[] = $this->encoder->encode($param);
        }
        $request  = new Request($endpoint, $params);
        $response = $this->client->send($request);
        if ($response->faultCode())
        {
            throw new WebFactionException($response->faultString(), $response->faultCode());
        }

        return $this->encoder->decode($response->value());
    }

    /**
     * @param int $length
     * @return string
     */
    public static function generatePassword($length = 42)
    {
        $string = '';
        while (($len = strlen($string)) < $length)
        {
            $size   = $length - $len;
            $bytes  = random_bytes($size);
            $string .= substr(str_replace(['/', '+', '='], '', base64_encode($bytes)), 0, $size);
        }

        return $string;
    }

    /**
     * @param array ...$versions
     * @throws WebFactionException
     */
    private function notAvailableInVersions(...$versions)
    {
        if (in_array($this->version, $versions))
        {
            throw new WebFactionException("This functionality is not available in version {$this->version} of the API", 403);
        }
    }
}