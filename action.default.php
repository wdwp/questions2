<?php
#-------------------------------------------------------------------------
# Module: Questions - a simple Questions & Answer module
# Version: 1.0, calguy1000 <calguy1000@hotmail.com>
#
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2005 by Ted Kulp (wishy@cmsmadesimple.org)
# This project's homepage is: http://www.cmsmadesimple.org
# The module's homepage is: http://dev.cmsmadesimple.org/projects/skeleton/
#
#-------------------------------------------------------------------------
#
# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
# Or read it online: http://www.gnu.org/licenses/licenses.html#GPL
#
#-------------------------------------------------------------------------

if( !isset($gCms) ) exit;


//
// Export params (except for mact and action) to smarty
// for use in various logic, etc.
//
foreach( $params as $key => $value )
{
  if( $key == 'mact' || $key == 'action' ) continue;

  $this->smarty->assign('param_'.$key,$value);
}

$mode = 'summary';
if( isset($params['mode'] ) )
  {
    $mode = $params['mode'];
  }
switch( $mode )
  {
  case 'summary':
    break;
  case 'form':
    break;
  case 'detailed':
    break;
  default:
    echo $this->Lang('error_invalidmode').": $mode";
    return;
  }
include(dirname(__FILE__).'/function.default_'.$mode.'.php');




// EOF
?>