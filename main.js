const { app, BrowserWindow } = require('electron');
const path = require('path');
const { spawn } = require('child_process');
const log = require('electron-log'); // Import electron-log

let mainWindow;
let phpProcess;

// Configure electron-log (optional)
log.transports.file.level = 'info'; // Log level: 'error', 'warn', 'info', 'verbose', 'debug', 'silly'
log.transports.console.level = 'debug'; // Log level for console output
log.transports.file.fileName = 'app.log'; // Log file name
log.transports.file.maxSize = 5 * 1024 * 1024; // Max log file size: 5MB
log.transports.file.format = '[{y}-{m}-{d} {h}:{i}:{s}.{ms}] [{level}] {text}'; // Custom log format

function createWindow() {
  // Log window creation
  log.info('Creating BrowserWindow');

  // Create the browser window
  mainWindow = new BrowserWindow({
    width: 1200,
    height: 800,
    autoHideMenuBar: true, // ✅ Hide the menu bar for a clean UI
    webPreferences: {
      nodeIntegration: true,
      contextIsolation: false,
      allowRunningInsecureContent: true, // Allow insecure content (if needed)
      webSecurity: false, // Disable web security (for testing only)
      enableRemoteModule: true, // Enable remote module (if needed)
    },
  });

  // Maximize the window
  mainWindow.maximize();
  log.info('BrowserWindow maximized');

  // Start PHP server
  startPHPServer();

  // Load your PHP app running on localhost
  mainWindow.loadURL('http://localhost:8000').catch((err) => {
    log.error('Failed to load URL:', err);
    mainWindow.loadFile('fallback.html'); // Load a local error page
  });

  // Open the DevTools (optional)
  // mainWindow.webContents.openDevTools();

  // Emitted when the window is closed
  mainWindow.on('closed', () => {
    log.info('BrowserWindow closed');
    mainWindow = null;
  });
}

function startPHPServer() {
  // Path to the PHP binary
  const phpPath = path.join(__dirname, 'php', 'php.exe'); // Adjust for macOS/Linux
  log.info(`PHP binary path: ${phpPath}`);

  // Path to your PHP app's entry point (e.g., index.php)
  const appPath = path.join(__dirname, 'www'); // Replace 'www' with your PHP app's folder
  log.info(`PHP app path: ${appPath}`);

  // Start the PHP server
  phpProcess = spawn(phpPath, ['-S', 'localhost:8000', '-t', appPath]);

  // Log PHP server output
  phpProcess.stdout.on('data', (data) => {
    log.info(`PHP Server: ${data}`);
  });

  phpProcess.stderr.on('data', (data) => {
    log.error(`PHP Server Error: ${data}`);
  });

  phpProcess.on('close', (code) => {
    log.info(`PHP Server process exited with code ${code}`);
  });
}

// This method will be called when Electron has finished initialization
app.on('ready', createWindow);

// Quit when all windows are closed
app.on('window-all-closed', () => {
  if (process.platform !== 'darwin') {
    log.info('Application quitting');
    app.quit();
  }
});

app.on('activate', () => {
  if (mainWindow === null) {
    log.info('Recreating BrowserWindow');
    createWindow();
  }
});

// Stop the PHP server when the app quits
app.on('will-quit', () => {
  if (phpProcess) {
    log.info('Stopping PHP server');
    phpProcess.kill();
  }
});