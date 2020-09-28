import {eventProgress} from '@/components/helper/HelperProgress';
import AWS from 'aws-sdk/global';
import S3 from 'aws-sdk/clients/s3';
import {eventUpload} from '@/components/helper/HelperUpload';

export default class UploadFile {
  generateFileName(length) {
    const today = new Date();
    const time = today.getHours() + today.getMinutes() + today.getSeconds();

    let result = '';
    const characters =
      'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    const charactersLength = characters.length;
    for (let i = 0; i < length; i++) {
      result += characters.charAt(
        Math.floor(Math.random() * charactersLength)
      );
    }
    return result + time;
  }

  formatExtension(ext) {
    if (
      ext === 'mp4' ||
      ext === 'avi' ||
      ext === 'mov' ||
      ext === 'flv' ||
      ext === 'wmv' ||
      ext === 'MP4' ||
      ext === 'AVI' ||
      ext === 'MOV' ||
      ext === 'FLV' ||
      ext === 'WMV'
    ) {
      return 'mp4';
    } else {
      return ext;
    }
  }

  upload(event, subdomain, folder) {
    const file = event.target.files[0];
    const fileName = file.name;
    const fileExt = this.formatExtension(fileName.split('.').pop());

    const newFileName = this.generateFileName(40) + '.' + fileExt;
    eventProgress.$emit('new-progress');

    AWS.config.update({
      accessKeyId: 'AKIA5AQZS5JMAWUELDG7',
      secretAccessKey: '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',
      region: 'us-east-1'
    });
    const bucket = new S3({params: {Bucket: 'sabiorealm'}});
    const params = {
      Key:
        '' +
        subdomain +
        '/' +
        'uploads/' +
        folder +
        '/' +
        newFileName +
        '',
      ContentType: file.type,
      Body: file
    };
    return new Promise((resolve, reject) => {
      bucket
        .upload(params)
        .on('httpUploadProgress', (evt) => {
          const percentCompleted = Math.round(
            parseInt((evt.loaded * 100) / evt.total)
          );
          eventProgress.$emit('new-percent', percentCompleted);
        })
        .send(() => {
          event.target.value = null;
          const el = event.target.parentElement.children[0];
          el.value = newFileName;
          eventProgress.$emit('finish-progress');
          eventUpload.$emit('finish-upload');
          resolve({fileName, newFileName});
        });

    });

  }
}
