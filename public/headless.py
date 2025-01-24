from selenium import webdriver
from selenium.webdriver.firefox.service import Service as FirefoxService
from selenium.webdriver.firefox.options import Options
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from bs4 import BeautifulSoup

# Configurer les options de Firefox pour utiliser le navigateur Tor
firefox_options = Options()
tor_binary_path = '/home/zango/Downloads/tor-browser/Browser/firefox'  # Chemin correct vers votre Tor Browser Firefox binary

firefox_options.binary_location = tor_binary_path
# Ne pas utiliser le mode headless pour voir le navigateur
# firefox_options.add_argument("--headless")  # Supprimer ou commenter cette ligne pour utiliser le mode visible
firefox_options.add_argument("--no-sandbox")
firefox_options.add_argument("--disable-dev-shm-usage")
firefox_options.add_argument("--disable-blink-features=AutomationControlled")
firefox_options.add_argument("--proxy-server=socks5://127.0.0.1:9050")  # Utiliser le proxy SOCKS de Tor

# Configurer le profil Firefox pour se connecter via Tor
firefox_profile = webdriver.FirefoxProfile()
firefox_profile.set_preference('network.proxy.type', 1)  # Configuration manuelle du proxy
firefox_profile.set_preference('network.proxy.socks', '127.0.0.1')
firefox_profile.set_preference('network.proxy.socks_port', 9050)  # Port Tor par défaut
firefox_profile.set_preference('network.proxy.socks_remote_dns', True)  # Activer la résolution DNS via Tor

# Joindre le profil aux options
firefox_options.profile = firefox_profile

# Chemin vers Geckodriver
geckodriver_path = '/usr/local/bin/geckodriver'  # Chemin correct vers votre Geckodriver

# Initialiser WebDriver avec la configuration Tor
driver = webdriver.Firefox(
    service=FirefoxService(executable_path=geckodriver_path),
    options=firefox_options
)

# URL à scraper
url = "https://books.toscrape.com/"  # Remplacez par l'URL de votre choix

# Visiter la page
driver.get(url)

# Utiliser WebDriverWait pour attendre que l'élément soit cliquable
try:
    # Attendre jusqu'à ce qu'un élément spécifique soit cliquable
    element = WebDriverWait(driver, 30).until(
        EC.element_to_be_clickable((By.XPATH, "//button[@id='submit']"))  # Remplacer par le sélecteur d'élément réel
    )
    print("Élément cliquable trouvé, prêt à être cliqué.")
    
    # Cliquer sur l'élément une fois qu'il est cliquable
    element.click()
except Exception as e:
    print(f"Erreur : {e}")

# Extraire la source de la page ou analyser avec BeautifulSoup
page_source = driver.page_source

# Optionnel, analyser avec BeautifulSoup
soup = BeautifulSoup(page_source, 'html.parser')
print(soup.prettify())

# Fermer le navigateur
driver.quit()

