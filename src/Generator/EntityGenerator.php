<?php

namespace JsonEntityGenerator\Generator;

use Symfony\Component\Console\Output\OutputInterface;

class EntityGenerator
{
    public function generateFromJson(string $json, OutputInterface $output)
    {
        $data = json_decode($json, true);

        foreach ($data as $entityName => $attributes) {
            $className = ucfirst($entityName);
            $code = "<?php\n\nnamespace App\\Entity;\n\nuse Doctrine\\ORM\\Mapping as ORM;\n\n/**\n * @ORM\\Entity\n */\nclass $className\n{\n";

            foreach ($attributes as $name => $type) {
                $code .= "    /**\n     * @ORM\\Column(type=\"$type\")\n     */\n";
                $code .= "    private \$$name;\n\n";
            }

            $code .= "}\n";

            file_put_contents("src/Entity/{$className}.php", $code);
            $output->writeln("Entité $className générée.");
        }
    }
}
