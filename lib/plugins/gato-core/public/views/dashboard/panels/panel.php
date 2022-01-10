<?php

echo $this->getSettingsTitle($tab);

echo "<form method='post' action=''>";
foreach($this->modules[$tab]["fields"] as $field) {
    echo $this->getSettingsField($tab, $field);
}
echo "<input type='submit' name='gato-core-submit' value='Save'/>";
echo "</form>";