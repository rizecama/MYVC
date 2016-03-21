<?php
/**
 * @version     $Id$
 * @author      IP-Tech Labs <labs@iptech-offshore.com>
 * @copyright   2010 IP-Tech
 * @package     JQuarks4s-Front-End
 * @link        http://www.iptechinside.com/labs/projects/show/jquarks-for-surveys
 * @since       1.0.0
 * @license     GNU/GPL2
 *
 *    This program is free software; you can redistribute it and/or
 *  modify it under the terms of the GNU General Public License
 *  as published by the Free Software Foundation; version 2
 *  of the License.
 *
 *    This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *    You should have received a copy of the GNU General Public License
 *  along with this program; if not, write to the Free Software
 *  Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 *  or see <http://www.gnu.org/licenses/>
 */


defined('_JEXEC') or die('');

// init default controller
$defaultController = 'Surveys';

// get controller name
$controller = JRequest::getCmd('controller', null);
$view       = JRequest::getCmd('view', null);

if ( ! is_null($controller))
{
    $controllerName = $controller;
}
elseif ( ! is_null($view))
{
    $controllerName = $view;
}
else
{
    $controllerName = $defaultController;
}

// include controller path
includeControllerPath($controllerName, $defaultController);

// Instantiate the controller
$classname = 'JQuarks4sController'.$controllerName;
$controllerObject = new $classname();

$controllerObject->execute(JRequest::getCmd('task'));

$controllerObject->redirect();

function includeControllerPath($controllerName, $defaultControllerName)
{
    $path = JPATH_COMPONENT.DS.'controllers'.DS.$controllerName.'.php';

    if ( file_exists($path))
    {
        require_once $path;
    }
    else
    {
        $path = JPATH_COMPONENT.DS.'controllers'.DS.$defaultControllerName.'.php';
        require_once $path;
    }
}