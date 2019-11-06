<?

namespace ApiV3\Modules;

class User extends Base
{
    /**
     * Для не ORM получения данных
     * Сначала обращается к этому классу,
     * потом к Base,
     * потом к классу в ORM
     * потом к классу Base в ORM
     */
}