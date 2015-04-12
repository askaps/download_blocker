
import java.io.File;
import java.io.FileInputStream;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.io.OutputStream;
import java.net.InetAddress;
import java.net.NetworkInterface;
import java.net.SocketException;
import java.nio.file.Files;
import java.nio.file.Path;
import java.util.ArrayList;
import java.util.Enumeration;
import java.util.Properties;
import java.util.logging.Level;
import java.util.logging.Logger;
import javafx.application.Application;
import javafx.beans.binding.Bindings;
import javafx.beans.property.DoubleProperty;
import javafx.scene.Scene;
import javafx.scene.layout.StackPane;
import javafx.scene.media.Media;
import javafx.scene.media.MediaPlayer;
import javafx.scene.media.MediaView;
import javafx.scene.paint.Color;
import javafx.stage.Stage;
import javax.crypto.Cipher;
import javax.crypto.CipherInputStream;
import javax.crypto.spec.SecretKeySpec;
import javax.swing.JFrame;
import javax.swing.JOptionPane;

public class StartVideo extends Application {

    private static String macAddress, fileName, videoName, workingDir;
    private static File outputFile;
    private String algo, path, env;
    private static StartVideo mObject;
    private static String OS = System.getProperty("os.name").toLowerCase();

    void playVideo() {
        launch();
    }

    public void decrypt() throws Exception {
        //generating same key
        System.err.println("decrypting");
        byte k[] = "HignDlPs".getBytes();
        SecretKeySpec key = new SecretKeySpec(k, mObject.algo.split("/")[0]);
        //creating and initialising cipher and cipher streams
        Cipher decrypt = Cipher.getInstance(mObject.algo);
        decrypt.init(Cipher.DECRYPT_MODE, key);
        //opening streams
        InputStream fis =this.getClass().getResourceAsStream("/"+videoName);
        try (CipherInputStream cin = new CipherInputStream(fis, decrypt)) {
            if (OS.indexOf("win") >= 0) {
                env = System.getenv("ProgramData");
                outputFile = new File(env + "/" + videoName.substring(0, videoName.lastIndexOf(".")));    
            }
            else if (OS.indexOf("nix") >= 0 || OS.indexOf("nux") >= 0 || OS.indexOf("aix") > 0 ) {
                //env = System.getenv("TMPDIR");
                outputFile = new File("/var/tmp" + "/." + videoName.substring(0, videoName.lastIndexOf(".")));    
            }else{
                outputFile = new File(workingDir + "/." + videoName.substring(0, videoName.lastIndexOf(".")));
            }
            outputFile.createNewFile();
            try (FileOutputStream fos = new FileOutputStream(outputFile)) {
                copy(cin, fos);
            }
        }
    }

    private void copy(InputStream is, OutputStream os) throws Exception {
        // encryption time varies with different size of buffer
        byte buf[] = new byte[4096000];  //4G buffer set
        int read = 0;
        while ((read = is.read(buf)) != -1) //reading
        {
            os.write(buf, 0, read);  //writing
        }
    }

    public static void main(String[] args) {
        macAddress = "{{MAC_ADDRESS_HERE}}";
        videoName = "{{VIDEO_NAME_HERE}}";
        workingDir = System.getProperty("user.dir");
        workingDir = workingDir.replace("\\", "/");

        fileName = workingDir + "/" + videoName;

        if (!checkMacAddress(macAddress)) {
            JFrame jf = new JFrame();
            jf.setDefaultCloseOperation(JFrame.DISPOSE_ON_CLOSE);
            System.out.println("mac doesn't match");
            JOptionPane.showMessageDialog(jf, "You're Not an Authenticated User.", "Sorry", JOptionPane.WARNING_MESSAGE);
            System.exit(0);
        } else {
            mObject = new StartVideo();
            mObject.algo = "DES/ECB/PKCS5Padding";
            mObject.path = fileName;
            try {
                mObject.decrypt();
                mObject.playVideo();
            } catch (Exception ex) {
                Logger.getLogger(StartVideo.class.getName()).log(Level.SEVERE, null, ex);
            }
        }
    }

    static ArrayList<String> getMac() {

        ArrayList<String> macList = new ArrayList<>();
        InetAddress ip;
        try {
            ip = InetAddress.getLocalHost();
            Enumeration<NetworkInterface> networks = NetworkInterface.getNetworkInterfaces();
            while (networks.hasMoreElements()) {
                NetworkInterface network = networks.nextElement();
                byte[] mac = network.getHardwareAddress();

                if (mac != null) {

                    StringBuilder sb = new StringBuilder();
                    for (int i = 0; i < mac.length; i++) {
                        sb.append(String.format("%02X%s", mac[i], (i < mac.length - 1) ? "-" : ""));
                    }
                    macList.add(sb.toString());
                }
            }
        } catch (SocketException e) {

            System.out.println(e);

        } catch (java.net.UnknownHostException ex) {
            Logger.getLogger(StartVideo.class.getName()).log(Level.SEVERE, null, ex);
        } finally {
            return macList;
        }
    }

    static Boolean checkMacAddress(String mac) {

        ArrayList macList = getMac();

        for (Object data : macList) {
            if (mac.equals((String) data)) {
                System.out.println("matched   : " + mac);
                return true;
            } else {
                System.out.println("unmatched : " + data);
            }
        }

        return false;
    }

    @Override
    public void start(Stage primaryStage) {
	try{
		String VideoPath = outputFile.getAbsolutePath();
		System.out.println("current video path : " + VideoPath);
		final File f = new File(VideoPath);
		final Media m = new Media(f.toURI().toString());
		final MediaPlayer mp = new MediaPlayer(m);
		final MediaView mv = new MediaView(mp);

		final DoubleProperty width = mv.fitWidthProperty();
		final DoubleProperty height = mv.fitHeightProperty();

		width.bind(Bindings.selectDouble(mv.sceneProperty(), "width"));
		height.bind(Bindings.selectDouble(mv.sceneProperty(), "height"));

		mv.setPreserveRatio(true);

		StackPane root = new StackPane();
		root.getChildren().add(mv);

		final Scene scene = new Scene(root, 960, 540);
		scene.setFill(Color.BLACK);

		primaryStage.setScene(scene);
		primaryStage.setTitle("Video Player");
		primaryStage.setFullScreen(true);
		primaryStage.show();

        Runtime.getRuntime().addShutdownHook(new Thread() {

            @Override
            public void run() {
                System.out.println(outputFile.delete());
            }
        });

		mp.play();
        if (OS.indexOf("win") >= 0) {
            Path file = outputFile.toPath();
            Files.setAttribute(file, "dos:hidden", true);
        }
		
	}catch(IOException e){
		System.out.println(e);
    	}
	}
}
