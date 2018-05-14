<?php
/**
 *
 * Search. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018, Ger
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace ger\searchts\event;

/**
 * @ignore
 */
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Search Event listener.
 */
class main_listener implements EventSubscriberInterface
{
    protected $config;
    protected $request;
    protected $db;
    protected $template;
    protected $lang;
    protected $phpbb_root_path;
    protected $php_ext;


    static public function getSubscribedEvents()
	{
		return array(
			'core.acp_board_config_edit_add'    => 'acp_setting_add',
			'core.memberlist_view_profile'      => 'memberlist_view_append',
			'core.search_backend_search_after'  => 'set_search',
		);
	}
        
        public function __construct(\phpbb\config\config $config, \phpbb\request\request $request, \phpbb\db\driver\driver_interface $db, \phpbb\template\template $template, \phpbb\language\language $lang, $phpbb_root_path, $php_ext) 
        {           
            $this->config           = $config;
            $this->request          = $request;
            $this->db               = $db;
            $this->template	    = $template;
            $this->lang             = $lang;
            $this->phpbb_root_path  = $phpbb_root_path;
            $this->php_ext          = $php_ext;
        }

        /**
         * Add option to the ACP
	 * @param \phpbb\event\data	$event	Event object
         */
        public function acp_setting_add($event)
        {
            if ($event['mode'] == 'features')
            {
                $display_vars = $event['display_vars'];            
                $add = array ('ger_sts_attachments'  => array('lang' => 'STS_ATTACHMENTS',	'validate' => 'bool',	'type' => 'radio:yes_no', 'explain' => true));
                $display_vars['vars'] = phpbb_insert_config_array($display_vars['vars'], $add, array('after' => 'display_last_subject'));
                $event['display_vars'] = $display_vars;
            }
        }
        
        /**
	 * Adds search link to memberlist_view
	 *
	 * @param \phpbb\event\data	$event	Event object
	 */
	public function memberlist_view_append($event)
	{
            $this->lang->add_lang('common', 'ger/searchts');
            
            $user_id = (int) $event['member']['user_id'];
            $sql = 'SELECT COUNT(*) as topics ' . $this->std_query($user_id);
            $result = $this->db->sql_query($sql);       
            $row = $this->db->sql_fetchrow($result);
            $this->db->sql_freeresult($result);
//            $attach = ($this->config['ger_sts_attachments'] ? 
            
            $this->template->assign_vars(array(
                'TOPICS'        => $row['topics'],
                'U_STS_SEARCH'  => append_sid($this->phpbb_root_path . 'search.' . $this->php_ext . '?author_id=' . $user_id . '&sr=topics&f=firstpost&search_attach=' . $this->config['ger_sts_attachments']),
            ));
	}
        
        /**
         * Alter search
	 * @param \phpbb\event\data	$event	Event object
         */       
        public function set_search($event)
        {
            if ($this->request->variable('search_attach', 0) !== 0) 
            {
                $user_id = $this->request->variable('author_id', 0);
                if ($user_id > 0)
                {
                    $sql = 'SELECT t.topic_id ' . $this->std_query($user_id);
                    $result = $this->db->sql_query($sql);  
                    while ($row = $this->db->sql_fetchrow($result)) 
                    {
                        $id_ary[] = $row['topic_id'];
                    }
                    $this->db->sql_freeresult($result);
                    $event['id_ary'] = $id_ary;
                    $event['total_match_count'] = count($id_ary);
                }
            }
        }
        
        /**
         * DRY.
         * @param int $user_id
         * @return string
         */
        private function std_query($user_id)
        {
            return 'FROM ' . POSTS_TABLE . ' p, ' . TOPICS_TABLE . ' t
                    WHERE  t.topic_first_post_id = p.post_id
                    AND t.topic_poster = ' . (int) $user_id . '
                    AND post_attachment = 1';
        }
        
}
