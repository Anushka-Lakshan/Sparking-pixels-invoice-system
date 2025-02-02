const { app } = require("electron");
const path = require("path");
const { spawn, exec } = require("child_process");

let phpProcess;
let browserProcess;

function startPHPServer() {
  const phpPath = path.join(__dirname, "php", "php.exe"); // Adjust for macOS/Linux
  const appPath = path.join(__dirname, "www"); // Replace 'www' with your PHP app's folder

  phpProcess = spawn(phpPath, ["-S", "localhost:8000", "-t", appPath]);

  phpProcess.stdout.on("data", (data) => {
    console.log(`PHP Server: ${data}`);
  });

  phpProcess.stderr.on("data", (data) => {
    console.error(`PHP Server Error: ${data}`);
  });

  phpProcess.on("close", (code) => {
    console.log(`PHP Server process exited with code ${code}`);
  });
}
function openInDefaultBrowser() {
    const appUrl = "http://localhost:8000";
  
    console.log("Opening browser...");
    browserProcess = exec(`start ${appUrl}`, (error) => {
      if (error) {
        console.error(`Error opening browser: ${error}`);
      }
    });
  
    // Delay quitting to allow browser to fully launch
    setTimeout(() => {
      console.log("Electron will now wait until the browser is closed.");
    }, 2000);
  }
  
  // Prevent Electron from quitting too soon
  app.whenReady().then(() => {
    startPHPServer();
    openInDefaultBrowser();
  });
  
  // Keep the Electron process alive
  app.on("window-all-closed", () => {
    // Do nothing here to prevent early exit
  });
  
  // Stop PHP server when Electron quits
  app.on("will-quit", () => {
    if (phpProcess) {
      phpProcess.kill();
    }
  });