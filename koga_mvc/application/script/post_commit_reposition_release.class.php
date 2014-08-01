<?php

require_once(dirname(__FILE__) . '/../vendor/File/Find.php');

class post_commit_reposition_release extends Script {
    public function execute(){
        $repository_hook_dirs = File_Find::search('hooks', '/var/svn/release', '*', true, 'directories');

        foreach($repository_hook_dirs as $dir){
            if(file_exists($dir)){
                exec(sprintf('cp %s/data/svn-hook/post-commit-release %s/post-commit', dirname(__FILE__) . '/../..', $dir));
                exec(sprintf('chmod 777 %s/post-commit', $dir));
            }
        }
    }
}
